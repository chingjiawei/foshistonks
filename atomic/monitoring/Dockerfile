FROM python:3
WORKDIR /user/src/app
COPY requirements.txt ./
RUN pip install --no-cache-dir -r requirements.txt
# RUN pip install python-telegram-bot
COPY ./monitoring.py .
CMD [ "python", "./monitoring.py" ]