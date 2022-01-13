def as_array: if type=="array" then . else [.] end;

map(select(.id)) as $formats |

{
  graph: {
    nodes: ([
      { id: "application/structure", name: "Structure", type: "application" },
      { id: "application/bibliographic", name: "Metadata", type: "application" },
      { id: "application/authority", name: "Authority", type: "application" },
      { id: "application/documents", name: "Document", type: "application" },
      { id: "application/model", name: "Model", type: "application" },
      { id: "application/schema", name: "Schema", type: "application" },
      { id: "application/query", name: "Query", type: "application" },
      { id: "application/patch", name: "Diff", type: "application" }
    ] + ($formats | map(select(.application)) | map({ 
        id,
        name: (.short // .title),
        type: "format"
      }))
    ),
    edges: (
      $formats | map(.id as $id | 
        ( 
          .application // [] | as_array | map({
            from: $id,
            to: ("application/" + .),
            type: "application"
          })
        )
        + ( .for // [] | as_array | map({ from: $id, to: ., type: "for" }) )
        + ( .base // [] | as_array | map({ from: $id, to: ., type: "base" }) )
        + ( .model // [] | as_array | map({ from: $id, to: ., type: "model" }) )
        + ( .profiles // [] | as_array | map({ from: $id, to: ., type: "profiles" }) )
      ) | flatten
    ),
    # base, for, model, profiles 
    nodeTypes: [
      { name: "application", color: "#2ca02c" },
      { name: "format", color: "#9467bd" }
    ],
    edgeTypes: [
      { name: "application", color: "#2ca02c" },
      { name: "for", color: "#00dd00" },
      { name: "model" },
      { name: "base" },
      { name: "profiles", color: "#99ffff" }
    ]
  }
}
