FROM postgres:9.5

ENV PG_APP_HOME="/etc/docker-postgresql"\
    PG_VERSION=9.5 \
    PG_USER=postgres \
    PG_HOME=/var/lib/postgresql \
    PG_RUNDIR=/run/postgresql \
    PG_LOGDIR=/var/log/postgresql \
    PG_CERTDIR=/etc/postgresql/certs

ENV PG_BINDIR=/usr/lib/postgresql/${PG_VERSION}/bin \
    PG_DATADIR=${PG_HOME}/data

RUN apt-get update \
    && apt-get install less \
    && rm -rf /var/lib/apt/lists/* \
    && mkdir -p /etc/postgresql/${PG_VERSION}/main \
    && ln -sf ${PG_DATADIR}/postgresql.conf /etc/postgresql/${PG_VERSION}/main/postgresql.conf \
    && ln -sf ${PG_DATADIR}/pg_hba.conf /etc/postgresql/${PG_VERSION}/main/pg_hba.conf \
    && ln -sf ${PG_DATADIR}/pg_ident.conf /etc/postgresql/${PG_VERSION}/main/pg_ident.conf \
    && rm -rf /var/lib/apt/lists/*


# Adjust PostgreSQL configuration so that remote connections to the
# database are possible.
RUN echo "host all  all    0.0.0.0/0  md5" >> /etc/postgresql/${PG_VERSION}/main/pg_hba.conf

# And add ``listen_addresses`` to ``/etc/postgresql/${PG_VERSION}/main/postgresql.conf``
RUN echo "listen_addresses='*'" >> /etc/postgresql/${PG_VERSION}/main/postgresql.conf
#RUN echo "logging_collector = on" >> /etc/postgresql/${PG_VERSION}/main/postgresql.conf
#ADD postgres-edit.sed /var/local
#RUN sed -i -f /var/local/postgres-edit.sed /etc/postgresql/${PG_VERSION}/main/postgresql.conf
#RUN echo "log_connections = on" >> /etc/postgresql/${PG_VERSION}/main/postgresql.conf
#RUN echo "log_disconnections = on" >> /etc/postgresql/${PG_VERSION}/main/postgresql.conf
#RUN echo "log_statement = 'all'" >> /etc/postgresql/${PG_VERSION}/main/postgresql.conf
#RUN echo "log_line_prefix = '%t &lt;%d %u %r&gt; %%'" >> /etc/postgresql/${PG_VERSION}/main/postgresql.conf