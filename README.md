This Application uses [laravel-google-calendar](https://github.com/spatie/laravel-google-calendar) package for the integration of google calender events. <br>

So By Following the Package Documentation, you will have to configure and enable your Google Calender API.
After Enabling the API you will get All the Credentials that is necessary for to create events.

You will get a file of credentials, copy that credentials and paste it in the Storage/app/google-calender/service-account-credentials.json.

Also You will have to Fill the GOOGLE_CALENDAR_ID in the .env that you will get from your google calender.

If you are using Wamp or Xammp make sure you have cainfo adn cafile enables to the path of the latest cacert.pem file.
