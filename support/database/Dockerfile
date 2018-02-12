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
    && rm -rf /var/lib/apt/lists/*


# Adjust PostgreSQL configuration so that remote connections to the
# database are possible.
RUN echo "host all  all    0.0.0.0/0  md5" >> ${PG_DATADIR}/pg_hba.conf

RUN echo "listen_addresses='*'" >> ${PG_DATADIR}/postgresql.conf