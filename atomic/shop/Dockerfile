FROM python:3
WORKDIR /user/src/app
COPY requirements.txt ./
RUN pip install --no-cache-dir -r requirements.txt
COPY ./shop.py .
CMD [ "python", "./shop.py" ]