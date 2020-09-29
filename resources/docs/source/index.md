---
title: API Reference

language_tabs:
- bash
- javascript
- php
- python

includes:

search: true

toc_footers:
- <a href='http://github.com/mpociot/documentarian'>Documentation Powered by Documentarian</a>
---
<!-- START_INFO -->
# Info

Welcome to the generated API reference.
[Get Postman Collection](http://localhost:40020/docs/collection.json)

<!-- END_INFO -->
## Authentication

```
Authorization: Basic {credentials}
```

This application uses basic auth headers to authenticate requests. Replace `{credentials}` in the examples below using an email/password pair, encoded using base64.

```
support@thinkbitsolutions.com:s3cRe+
```

For example, the email, `support@thinkbitsolutions.com`, and password, `s3cRe+`, separated by a colon then encoded using base64 will have the following request header.

```
Authorization: Basic c3VwcG9ydEB0aGlua2JpdHNvbHV0aW9ucy5jb206czNjUmUr
```

Related guide: [Basic authentication scheme](https://developer.mozilla.org/en-US/docs/Web/HTTP/Authentication#Basic_authentication_scheme).


#Core


<!-- START_aa052b285c2cd6861cc83e8aadf994c5 -->
## Scheduling Jobs with App Engine

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
On instances where the application is hosted on Google Cloud's App
Engine, cron jobs can only be implemented through invoking a URL. By
default, ThinkBIT's CI/CD will use the API to trigger scheduled tasks.

Related guide: [Validating cron requests](https://cloud.google.com/appengine/docs/flexible/php/scheduling-jobs-with-cron-yaml#validating_cron_requests).

> Example request:

```bash
curl -X GET \
    -G "http://localhost:40020/api/cron" \
    -H "X-Appengine-Cron: true" \
    -H "X-Forwarded-For: 10.0.0.1"
```

```javascript
const url = new URL(
    "http://localhost:40020/api/cron"
);

let headers = {
    "X-Appengine-Cron": "true",
    "X-Forwarded-For": "10.0.0.1",
    "Accept": "application/json",
    "Content-Type": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'http://localhost:40020/api/cron',
    [
        'headers' => [
            'X-Appengine-Cron' => 'true',
            'X-Forwarded-For' => '10.0.0.1',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://localhost:40020/api/cron'
headers = {
  'X-Appengine-Cron': 'true',
  'X-Forwarded-For': '10.0.0.1'
}
response = requests.request('GET', url, headers=headers)
response.json()
```


> Example response (204):

```json
null
```
> Example response (401):

```json
{
    "message": "Request did not contain a valid HTTP header."
}
```
> Example response (403):

```json
{
    "message": "Cron request did not come from a valid IP address."
}
```

### HTTP Request
`GET api/cron`


<!-- END_aa052b285c2cd6861cc83e8aadf994c5 -->

#Users > FCM Registration Tokens


A Firebase Cloud Messaging (FCM) Registration Token is used to register
devices to a single device group.

Related guides: [Send messages to device groups](https://firebase.google.com/docs/cloud-messaging/js/device-group) and [Access the registration token](https://firebase.google.com/docs/cloud-messaging/js/client#access_the_registration_token).
<!-- START_32d5e74b2ed81000a6deb94f3304c509 -->
## Add a device

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
We recommend calling this API whenever [the user logs in](https://firebase.google.com/docs/cloud-messaging/js/client#retrieve-the-current-registration-token)
and [a new token is generated](https://firebase.google.com/docs/cloud-messaging/js/client#monitor-token-refresh).

A device group will automatically be created for the provided `{user}`.
This automatically tracks devices and adds new devices to existing device
groups.

**NOTE:** The oldest device of a device group with ~20 members will be
removed.

> Example request:

```bash
curl -X POST \
    "http://localhost:40020/api/users/1/fcm_registration_tokens" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: Basic {credentials}" \
    -d '{"registration_id":"fIAe0YS9S1-FyQDlQ24Edu:APA91bF2NDdGgK8UR26uSFvXw2RSXGJ2A1o57f2yh_iDSQ8gYbszgPEcWnanlQCeYO7okp6XNqEVwtjMSVz8RQPNpMtzb4vseRKGov5Wm6PkpK5gDy30SkzrtnjIvCO4nHqTpfmjL2wo"}'

```

```javascript
const url = new URL(
    "http://localhost:40020/api/users/1/fcm_registration_tokens"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "Basic {credentials}",
};

let body = {
    "registration_id": "fIAe0YS9S1-FyQDlQ24Edu:APA91bF2NDdGgK8UR26uSFvXw2RSXGJ2A1o57f2yh_iDSQ8gYbszgPEcWnanlQCeYO7okp6XNqEVwtjMSVz8RQPNpMtzb4vseRKGov5Wm6PkpK5gDy30SkzrtnjIvCO4nHqTpfmjL2wo"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'http://localhost:40020/api/users/1/fcm_registration_tokens',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Basic {credentials}',
        ],
        'json' => [
            'registration_id' => 'fIAe0YS9S1-FyQDlQ24Edu:APA91bF2NDdGgK8UR26uSFvXw2RSXGJ2A1o57f2yh_iDSQ8gYbszgPEcWnanlQCeYO7okp6XNqEVwtjMSVz8RQPNpMtzb4vseRKGov5Wm6PkpK5gDy30SkzrtnjIvCO4nHqTpfmjL2wo',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://localhost:40020/api/users/1/fcm_registration_tokens'
payload = {
    "registration_id": "fIAe0YS9S1-FyQDlQ24Edu:APA91bF2NDdGgK8UR26uSFvXw2RSXGJ2A1o57f2yh_iDSQ8gYbszgPEcWnanlQCeYO7okp6XNqEVwtjMSVz8RQPNpMtzb4vseRKGov5Wm6PkpK5gDy30SkzrtnjIvCO4nHqTpfmjL2wo"
}
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json',
  'Authorization': 'Basic {credentials}'
}
response = requests.request('POST', url, headers=headers, json=payload)
response.json()
```


> Example response (201):

```json
{
    "id": 1,
    "user_id": 1,
    "registration_id": "fIAe0YS9S1-FyQDlQ24Edu:APA91bF2NDdGgK8UR26uSFvXw2RSXGJ2A1o57f2yh_iDSQ8gYbszgPEcWnanlQCeYO7okp6XNqEVwtjMSVz8RQPNpMtzb4vseRKGov5Wm6PkpK5gDy30SkzrtnjIvCO4nHqTpfmjL2wo",
    "created_at": "2020-03-18 06:35:22",
    "updated_at": "2020-03-18 06:35:22"
}
```
> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "registration_id": [
            "The registration id field is required."
        ]
    }
}
```

### HTTP Request
`POST api/users/{user}/fcm_registration_tokens`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `user` |  required  | The ID of the user.
#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `registration_id` | string |  required  | The registration token.
    
<!-- END_32d5e74b2ed81000a6deb94f3304c509 -->

<!-- START_0de93f745b776694403432d0651fe2a8 -->
## Remove a device

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
We recommend calling this API whenever the user logs out so that:
* the user will not receive a notification on that device, and
* the device group will not reach its ~20 member limit.

The device group will automatically be deleted for the provided `{user}`
if there are no more members, but this should not impact you.

> Example request:

```bash
curl -X DELETE \
    "http://localhost:40020/api/users/1/fcm_registration_tokens" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: Basic {credentials}" \
    -d '{"registration_id":"fIAe0YS9S1-FyQDlQ24Edu:APA91bF2NDdGgK8UR26uSFvXw2RSXGJ2A1o57f2yh_iDSQ8gYbszgPEcWnanlQCeYO7okp6XNqEVwtjMSVz8RQPNpMtzb4vseRKGov5Wm6PkpK5gDy30SkzrtnjIvCO4nHqTpfmjL2wo"}'

```

```javascript
const url = new URL(
    "http://localhost:40020/api/users/1/fcm_registration_tokens"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "Basic {credentials}",
};

let body = {
    "registration_id": "fIAe0YS9S1-FyQDlQ24Edu:APA91bF2NDdGgK8UR26uSFvXw2RSXGJ2A1o57f2yh_iDSQ8gYbszgPEcWnanlQCeYO7okp6XNqEVwtjMSVz8RQPNpMtzb4vseRKGov5Wm6PkpK5gDy30SkzrtnjIvCO4nHqTpfmjL2wo"
}

fetch(url, {
    method: "DELETE",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->delete(
    'http://localhost:40020/api/users/1/fcm_registration_tokens',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Basic {credentials}',
        ],
        'json' => [
            'registration_id' => 'fIAe0YS9S1-FyQDlQ24Edu:APA91bF2NDdGgK8UR26uSFvXw2RSXGJ2A1o57f2yh_iDSQ8gYbszgPEcWnanlQCeYO7okp6XNqEVwtjMSVz8RQPNpMtzb4vseRKGov5Wm6PkpK5gDy30SkzrtnjIvCO4nHqTpfmjL2wo',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```

```python
import requests
import json

url = 'http://localhost:40020/api/users/1/fcm_registration_tokens'
payload = {
    "registration_id": "fIAe0YS9S1-FyQDlQ24Edu:APA91bF2NDdGgK8UR26uSFvXw2RSXGJ2A1o57f2yh_iDSQ8gYbszgPEcWnanlQCeYO7okp6XNqEVwtjMSVz8RQPNpMtzb4vseRKGov5Wm6PkpK5gDy30SkzrtnjIvCO4nHqTpfmjL2wo"
}
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json',
  'Authorization': 'Basic {credentials}'
}
response = requests.request('DELETE', url, headers=headers, json=payload)
response.json()
```


> Example response (204):

```json
null
```
> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "registration_id": [
            "The registration id field is required."
        ]
    }
}
```

### HTTP Request
`DELETE api/users/{user}/fcm_registration_tokens`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `user` |  required  | The ID of the user.
#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `registration_id` | string |  required  | The registration token.
    
<!-- END_0de93f745b776694403432d0651fe2a8 -->


