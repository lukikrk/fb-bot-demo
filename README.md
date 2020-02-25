This application is made to demonstrate how to create Facebook Messenger chatbot using:
- Symfony
- kerox/messenger library

To run application install Makefile support and then type `make` in the console.
Application has build in docker environment.

If you want to create public address for you local instance of the app you can use build-in ngrok command from nginx container:
- `docker exec -it fb_bot_demo_nginx sh`
- `ngrok http 80`