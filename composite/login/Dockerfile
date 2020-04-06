FROM python:3
WORKDIR /user/src/app
COPY requirements.txt ./
RUN pip install --no-cache-dir -r requirements.txt
COPY ./login.py .
CMD [ "python", "./login.py" ]