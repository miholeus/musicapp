# sed script to edit postgresql configuration

s/^#\(logging_collector = \).*/\1on/
s/^\(max_connections = \).*/\11000/