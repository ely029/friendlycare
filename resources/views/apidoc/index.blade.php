<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>API Reference</title>

    <link rel="stylesheet" href="{{ asset('/docs/css/style.css') }}" />
    <script src="{{ asset('/docs/js/all.js') }}"></script>


          <script>
        $(function() {
            setupLanguages(["bash","javascript","php","python"]);
        });
      </script>
      </head>

  <body class="">
    <a href="#" id="nav-button">
      <span>
        NAV
        <img src="/docs/images/navbar.png" />
      </span>
    </a>
    <div class="tocify-wrapper">
        <img src="/docs/images/logo.png" width="230" height="52" />
                    <div class="lang-selector">
                                  <a href="#" data-language-name="bash">bash</a>
                                  <a href="#" data-language-name="javascript">javascript</a>
                                  <a href="#" data-language-name="php">php</a>
                                  <a href="#" data-language-name="python">python</a>
                            </div>
                            <div class="search">
              <input type="text" class="search" id="input-search" placeholder="Search">
            </div>
            <ul class="search-results"></ul>
              <div id="toc">
      </div>
                    <ul class="toc-footer">
                                  <li><a href='http://github.com/mpociot/documentarian'>Documentation Powered by Documentarian</a></li>
                            </ul>
            </div>
    <div class="page-wrapper">
      <div class="dark-box"></div>
      <div class="content">
          <!-- START_INFO -->
<h1>Info</h1>
<p>Welcome to the generated API reference.
<a href="{{ route("apidoc.json") }}">Get Postman Collection</a></p>
<!-- END_INFO -->
<h2>Authentication</h2>
<pre><code>Authorization: Basic {credentials}</code></pre>
<p>This application uses basic auth headers to authenticate requests. Replace <code>{credentials}</code> in the examples below using an email/password pair, encoded using base64.</p>
<pre><code>support@thinkbitsolutions.com:s3cRe+</code></pre>
<p>For example, the email, <code>support@thinkbitsolutions.com</code>, and password, <code>s3cRe+</code>, separated by a colon then encoded using base64 will have the following request header.</p>
<pre><code>Authorization: Basic c3VwcG9ydEB0aGlua2JpdHNvbHV0aW9ucy5jb206czNjUmUr</code></pre>
<p>Related guide: <a href="https://developer.mozilla.org/en-US/docs/Web/HTTP/Authentication#Basic_authentication_scheme">Basic authentication scheme</a>.</p>
<h1>Core</h1>
<!-- START_aa052b285c2cd6861cc83e8aadf994c5 -->
<h2>Scheduling Jobs with App Engine</h2>
<p><br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
On instances where the application is hosted on Google Cloud's App
Engine, cron jobs can only be implemented through invoking a URL. By
default, ThinkBIT's CI/CD will use the API to trigger scheduled tasks.</p>
<p>Related guide: <a href="https://cloud.google.com/appengine/docs/flexible/php/scheduling-jobs-with-cron-yaml#validating_cron_requests">Validating cron requests</a>.</p>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "http://localhost:40020/api/cron" \
    -H "X-Appengine-Cron: true" \
    -H "X-Forwarded-For: 10.0.0.1"</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'http://localhost:40020/api/cron',
    [
        'headers' =&gt; [
            'X-Appengine-Cron' =&gt; 'true',
            'X-Forwarded-For' =&gt; '10.0.0.1',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<pre><code class="language-python">import requests
import json

url = 'http://localhost:40020/api/cron'
headers = {
  'X-Appengine-Cron': 'true',
  'X-Forwarded-For': '10.0.0.1'
}
response = requests.request('GET', url, headers=headers)
response.json()</code></pre>
<blockquote>
<p>Example response (204):</p>
</blockquote>
<pre><code class="language-json">null</code></pre>
<blockquote>
<p>Example response (401):</p>
</blockquote>
<pre><code class="language-json">{
    "message": "Request did not contain a valid HTTP header."
}</code></pre>
<blockquote>
<p>Example response (403):</p>
</blockquote>
<pre><code class="language-json">{
    "message": "Cron request did not come from a valid IP address."
}</code></pre>
<h3>HTTP Request</h3>
<p><code>GET api/cron</code></p>
<!-- END_aa052b285c2cd6861cc83e8aadf994c5 -->
<h1>Users &gt; FCM Registration Tokens</h1>
<p>A Firebase Cloud Messaging (FCM) Registration Token is used to register
devices to a single device group.</p>
<p>Related guides: <a href="https://firebase.google.com/docs/cloud-messaging/js/device-group">Send messages to device groups</a> and <a href="https://firebase.google.com/docs/cloud-messaging/js/client#access_the_registration_token">Access the registration token</a>.</p>
<!-- START_32d5e74b2ed81000a6deb94f3304c509 -->
<h2>Add a device</h2>
<p><br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
We recommend calling this API whenever <a href="https://firebase.google.com/docs/cloud-messaging/js/client#retrieve-the-current-registration-token">the user logs in</a>
and <a href="https://firebase.google.com/docs/cloud-messaging/js/client#monitor-token-refresh">a new token is generated</a>.</p>
<p>A device group will automatically be created for the provided <code>{user}</code>.
This automatically tracks devices and adds new devices to existing device
groups.</p>
<p><strong>NOTE:</strong> The oldest device of a device group with ~20 members will be
removed.</p>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X POST \
    "http://localhost:40020/api/users/1/fcm_registration_tokens" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: Basic {credentials}" \
    -d '{"registration_id":"fIAe0YS9S1-FyQDlQ24Edu:APA91bF2NDdGgK8UR26uSFvXw2RSXGJ2A1o57f2yh_iDSQ8gYbszgPEcWnanlQCeYO7okp6XNqEVwtjMSVz8RQPNpMtzb4vseRKGov5Wm6PkpK5gDy30SkzrtnjIvCO4nHqTpfmjL2wo"}'
</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;post(
    'http://localhost:40020/api/users/1/fcm_registration_tokens',
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
            'Authorization' =&gt; 'Basic {credentials}',
        ],
        'json' =&gt; [
            'registration_id' =&gt; 'fIAe0YS9S1-FyQDlQ24Edu:APA91bF2NDdGgK8UR26uSFvXw2RSXGJ2A1o57f2yh_iDSQ8gYbszgPEcWnanlQCeYO7okp6XNqEVwtjMSVz8RQPNpMtzb4vseRKGov5Wm6PkpK5gDy30SkzrtnjIvCO4nHqTpfmjL2wo',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<pre><code class="language-python">import requests
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
response.json()</code></pre>
<blockquote>
<p>Example response (201):</p>
</blockquote>
<pre><code class="language-json">{
    "id": 1,
    "user_id": 1,
    "registration_id": "fIAe0YS9S1-FyQDlQ24Edu:APA91bF2NDdGgK8UR26uSFvXw2RSXGJ2A1o57f2yh_iDSQ8gYbszgPEcWnanlQCeYO7okp6XNqEVwtjMSVz8RQPNpMtzb4vseRKGov5Wm6PkpK5gDy30SkzrtnjIvCO4nHqTpfmjL2wo",
    "created_at": "2020-03-18 06:35:22",
    "updated_at": "2020-03-18 06:35:22"
}</code></pre>
<blockquote>
<p>Example response (422):</p>
</blockquote>
<pre><code class="language-json">{
    "message": "The given data was invalid.",
    "errors": {
        "registration_id": [
            "The registration id field is required."
        ]
    }
}</code></pre>
<h3>HTTP Request</h3>
<p><code>POST api/users/{user}/fcm_registration_tokens</code></p>
<h4>URL Parameters</h4>
<table>
<thead>
<tr>
<th>Parameter</th>
<th>Status</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td><code>user</code></td>
<td>required</td>
<td>The ID of the user.</td>
</tr>
</tbody>
</table>
<h4>Body Parameters</h4>
<table>
<thead>
<tr>
<th>Parameter</th>
<th>Type</th>
<th>Status</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td><code>registration_id</code></td>
<td>string</td>
<td>required</td>
<td>The registration token.</td>
</tr>
</tbody>
</table>
<!-- END_32d5e74b2ed81000a6deb94f3304c509 -->
<!-- START_0de93f745b776694403432d0651fe2a8 -->
<h2>Remove a device</h2>
<p><br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
We recommend calling this API whenever the user logs out so that:</p>
<ul>
<li>the user will not receive a notification on that device, and</li>
<li>the device group will not reach its ~20 member limit.</li>
</ul>
<p>The device group will automatically be deleted for the provided <code>{user}</code>
if there are no more members, but this should not impact you.</p>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X DELETE \
    "http://localhost:40020/api/users/1/fcm_registration_tokens" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: Basic {credentials}" \
    -d '{"registration_id":"fIAe0YS9S1-FyQDlQ24Edu:APA91bF2NDdGgK8UR26uSFvXw2RSXGJ2A1o57f2yh_iDSQ8gYbszgPEcWnanlQCeYO7okp6XNqEVwtjMSVz8RQPNpMtzb4vseRKGov5Wm6PkpK5gDy30SkzrtnjIvCO4nHqTpfmjL2wo"}'
</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;delete(
    'http://localhost:40020/api/users/1/fcm_registration_tokens',
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
            'Authorization' =&gt; 'Basic {credentials}',
        ],
        'json' =&gt; [
            'registration_id' =&gt; 'fIAe0YS9S1-FyQDlQ24Edu:APA91bF2NDdGgK8UR26uSFvXw2RSXGJ2A1o57f2yh_iDSQ8gYbszgPEcWnanlQCeYO7okp6XNqEVwtjMSVz8RQPNpMtzb4vseRKGov5Wm6PkpK5gDy30SkzrtnjIvCO4nHqTpfmjL2wo',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<pre><code class="language-python">import requests
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
response.json()</code></pre>
<blockquote>
<p>Example response (204):</p>
</blockquote>
<pre><code class="language-json">null</code></pre>
<blockquote>
<p>Example response (422):</p>
</blockquote>
<pre><code class="language-json">{
    "message": "The given data was invalid.",
    "errors": {
        "registration_id": [
            "The registration id field is required."
        ]
    }
}</code></pre>
<h3>HTTP Request</h3>
<p><code>DELETE api/users/{user}/fcm_registration_tokens</code></p>
<h4>URL Parameters</h4>
<table>
<thead>
<tr>
<th>Parameter</th>
<th>Status</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td><code>user</code></td>
<td>required</td>
<td>The ID of the user.</td>
</tr>
</tbody>
</table>
<h4>Body Parameters</h4>
<table>
<thead>
<tr>
<th>Parameter</th>
<th>Type</th>
<th>Status</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td><code>registration_id</code></td>
<td>string</td>
<td>required</td>
<td>The registration token.</td>
</tr>
</tbody>
</table>
<!-- END_0de93f745b776694403432d0651fe2a8 -->
      </div>
      <div class="dark-box">
                        <div class="lang-selector">
                                    <a href="#" data-language-name="bash">bash</a>
                                    <a href="#" data-language-name="javascript">javascript</a>
                                    <a href="#" data-language-name="php">php</a>
                                    <a href="#" data-language-name="python">python</a>
                              </div>
                </div>
    </div>
  </body>
</html>