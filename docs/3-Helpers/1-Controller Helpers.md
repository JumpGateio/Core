# Controller Helpers

- [Introduction](#introduction)
- [setViewData](#set-view-data)
- [setJavascriptData](#set-javascript-data)

<a name="introduction"></a>
## Introduction
The JumpGate BaseController class adds a lot of extra functionality to help with common tasks.  To use it you should have 
your `Controller` class (the one all of your other controllers extend) extend `JumpGate\Core\Http\Controllers\BaseController`.

<a name="set-view-data"></a>
## setViewData
This method allows you to pass data to the view.  It accepts either a key/value pair of parameters or it will accept PHP's 
`compact()` function.

```php
$this->setViewData('user', User::find($userId);
$this->setViewData(compact('user'));
```

> Both of these will send a variable named `$user` to the view.

<a name="set-javascript-data"></a>
## setJavascriptData
This method allows you to pass data directly to javascript.  It accepts either a key/value pair of parameters or it will accept PHP's 
`compact()` function.  You can access this in your javascript by using your set namespace followed by the variable name.

> You can set your namespace in `app/config/javascript.php` or in you `.env` file using the key `JS_NAMESPACE`.  It is `app`
by default.

In your controller:
```php
$this->setJavascriptData('user', User::find($userId);
$this->setJavascriptData(compact('user'));
```

> All of these will send a variable named `js_namespace.user` to javascript.

In your javascript:
```
let user = js_namespace.user
````
