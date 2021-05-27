# Firebase Notifications Yii2

This extension will make send firebase notifications easy to do for the Yii2 framework.

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes. See deployment for notes on how to deploy the project on a live system.


### Installing

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
composer require inquid/yii2-firebase-notifications
```

or add

```
"inquid/yii2-firebase-notifications": "dev-master"
```
to the require section of your composer.json file.

## Usage

```ruby
$service = new FirebaseNotifications(['authKey' => 'YOUR_KEY']);

$service->sendNotification($tokens, $message);
```
You can clone the android build [here](https://github.com/Amr-alshroof/Fcm-Android),
and use it to test your code.


