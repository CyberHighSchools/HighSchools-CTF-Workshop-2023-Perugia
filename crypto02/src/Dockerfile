FROM python:3.11-alpine
WORKDIR /app

COPY requirements.txt ./
RUN pip3 install -r requirements.txt \
    && rm requirements.txt

COPY src/ ./

CMD [ "gunicorn", "app:app", "-c", "/app/gunicorn_config.py" ]
