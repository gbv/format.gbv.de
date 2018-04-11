#!/usr/bin/env perl
use v5.14;
use Pandoc;
use Pandoc::Elements;
use File::Find;
use JSON::PP;

my %items;

# read items from files
find({
    no_chdir => 1,
    wanted => sub {
        return if $_ !~ qr{^pages((/[a-z0-9-]+)+)\.md$};
        my $id = substr $1, 1;
        unless ($items{$id} = pandoc->file($_)) {
            say STDERR "failed to read $_";
        }    
    } 
  }, 'pages');

# TODO: read items from LOV and/or from cache

# check hyperlinks between items
foreach my $id (keys %items) {
    my $doc = $items{$id};

    my @path = split '/', $id;
    pop @path;

    $doc->walk( Link => sub {            
        (my $url = $_->url) !~ qr{^([a-z]+:)?//} or return;
        my @base = @path;
        pop @base while $url =~ s{^(\.\./)}{};

        $url = join '/', @base, $url;
        unless ($items{$url}) {
            say STDERR "missing target '$url' in $id";
        }
    });
}

# remove internal keys
foreach my $format (values %items) {
    foreach (qw(markdown arguments javascript css broader)) {
        delete $format->meta->{$_};
    }
}

# TODO: extend Pandoc::Metadata to ->tree (see open GitHub issue)

#JSON->new->utf8->pretty->encode(
