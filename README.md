## Installation

- Clone this repository on your local computer.
- Build docker image.
- Run docker image.

```shell
git clone https://github.com/jimmy12613/LAMP_PROJECT.git
cd LAMP_PROJECT/
docker build -t my-php .
cd src
docker run -d -p 8000:80 -v `pwd`:/var/www/html my-php
```

LAMP_PROJECT is now ready, You can access it via `http://127.0.0.1:8000`