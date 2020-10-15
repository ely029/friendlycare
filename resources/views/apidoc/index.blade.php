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
        <img src="/docs/images/logo.png" />
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
    -G "http://localhost/api/cron" \
    -H "X-Appengine-Cron: true" \
    -H "X-Forwarded-For: 10.0.0.1"</code></pre>
<pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/cron"
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
    'http://localhost/api/cron',
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

url = 'http://localhost/api/cron'
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
<!-- START_e0165fff4425cb1a862f116f1e3188d2 -->
<h2>api/patients/register</h2>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X POST \
    "http://localhost/api/patients/register" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: Basic {credentials}"</code></pre>
<pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/patients/register"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "Basic {credentials}",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;post(
    'http://localhost/api/patients/register',
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
            'Authorization' =&gt; 'Basic {credentials}',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<pre><code class="language-python">import requests
import json

url = 'http://localhost/api/patients/register'
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json',
  'Authorization': 'Basic {credentials}'
}
response = requests.request('POST', url, headers=headers)
response.json()</code></pre>
<h3>HTTP Request</h3>
<p><code>POST api/patients/register</code></p>
<!-- END_e0165fff4425cb1a862f116f1e3188d2 -->
<!-- START_69a668aacd87b9bdfe9c8b762f0dbc0a -->
<h2>api/patients/login</h2>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X POST \
    "http://localhost/api/patients/login" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: Basic {credentials}"</code></pre>
<pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/patients/login"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "Basic {credentials}",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;post(
    'http://localhost/api/patients/login',
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
            'Authorization' =&gt; 'Basic {credentials}',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<pre><code class="language-python">import requests
import json

url = 'http://localhost/api/patients/login'
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json',
  'Authorization': 'Basic {credentials}'
}
response = requests.request('POST', url, headers=headers)
response.json()</code></pre>
<h3>HTTP Request</h3>
<p><code>POST api/patients/login</code></p>
<!-- END_69a668aacd87b9bdfe9c8b762f0dbc0a -->
<!-- START_e8533a34c7df873820e307edc1bac95f -->
<h2>api/patients/users</h2>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "http://localhost/api/patients/users" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: Basic {credentials}"</code></pre>
<pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/patients/users"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "Basic {credentials}",
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
    'http://localhost/api/patients/users',
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
            'Authorization' =&gt; 'Basic {credentials}',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<pre><code class="language-python">import requests
import json

url = 'http://localhost/api/patients/users'
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json',
  'Authorization': 'Basic {credentials}'
}
response = requests.request('GET', url, headers=headers)
response.json()</code></pre>
<h3>HTTP Request</h3>
<p><code>GET api/patients/users</code></p>
<!-- END_e8533a34c7df873820e307edc1bac95f -->
<!-- START_6e89201d89312ab1f657862f950e89c0 -->
<h2>api/patients/id/{id}</h2>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "http://localhost/api/patients/id/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: Basic {credentials}"</code></pre>
<pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/patients/id/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "Basic {credentials}",
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
    'http://localhost/api/patients/id/1',
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
            'Authorization' =&gt; 'Basic {credentials}',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<pre><code class="language-python">import requests
import json

url = 'http://localhost/api/patients/id/1'
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json',
  'Authorization': 'Basic {credentials}'
}
response = requests.request('GET', url, headers=headers)
response.json()</code></pre>
<h3>HTTP Request</h3>
<p><code>GET api/patients/id/{id}</code></p>
<!-- END_6e89201d89312ab1f657862f950e89c0 -->
<!-- START_bad40d3db970ed31027e75393d087dae -->
<h2>api/patients/update</h2>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X POST \
    "http://localhost/api/patients/update" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: Basic {credentials}"</code></pre>
<pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/patients/update"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "Basic {credentials}",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;post(
    'http://localhost/api/patients/update',
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
            'Authorization' =&gt; 'Basic {credentials}',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<pre><code class="language-python">import requests
import json

url = 'http://localhost/api/patients/update'
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json',
  'Authorization': 'Basic {credentials}'
}
response = requests.request('POST', url, headers=headers)
response.json()</code></pre>
<h3>HTTP Request</h3>
<p><code>POST api/patients/update</code></p>
<!-- END_bad40d3db970ed31027e75393d087dae -->
<!-- START_46334a0d9d5ca6e0848e85a82e4454b4 -->
<h2>api/consentform</h2>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "http://localhost/api/consentform" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: Basic {credentials}"</code></pre>
<pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/consentform"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "Basic {credentials}",
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
    'http://localhost/api/consentform',
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
            'Authorization' =&gt; 'Basic {credentials}',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<pre><code class="language-python">import requests
import json

url = 'http://localhost/api/consentform'
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json',
  'Authorization': 'Basic {credentials}'
}
response = requests.request('GET', url, headers=headers)
response.json()</code></pre>
<h3>HTTP Request</h3>
<p><code>GET api/consentform</code></p>
<!-- END_46334a0d9d5ca6e0848e85a82e4454b4 -->
<!-- START_f6a135a09acc73f810a92544c9113256 -->
<h2>api/patients/verification</h2>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X POST \
    "http://localhost/api/patients/verification" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: Basic {credentials}"</code></pre>
<pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/patients/verification"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "Basic {credentials}",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;post(
    'http://localhost/api/patients/verification',
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
            'Authorization' =&gt; 'Basic {credentials}',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<pre><code class="language-python">import requests
import json

url = 'http://localhost/api/patients/verification'
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json',
  'Authorization': 'Basic {credentials}'
}
response = requests.request('POST', url, headers=headers)
response.json()</code></pre>
<h3>HTTP Request</h3>
<p><code>POST api/patients/verification</code></p>
<!-- END_f6a135a09acc73f810a92544c9113256 -->
<!-- START_52762fc85d933a8ce449cd07d5febe21 -->
<h2>api/patients/reset</h2>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X POST \
    "http://localhost/api/patients/reset" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: Basic {credentials}"</code></pre>
<pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/patients/reset"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "Basic {credentials}",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;post(
    'http://localhost/api/patients/reset',
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
            'Authorization' =&gt; 'Basic {credentials}',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<pre><code class="language-python">import requests
import json

url = 'http://localhost/api/patients/reset'
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json',
  'Authorization': 'Basic {credentials}'
}
response = requests.request('POST', url, headers=headers)
response.json()</code></pre>
<h3>HTTP Request</h3>
<p><code>POST api/patients/reset</code></p>
<!-- END_52762fc85d933a8ce449cd07d5febe21 -->
<!-- START_06ca21682ebf46506c2c0dc3a1b2b3ed -->
<h2>api/basicpages/consent</h2>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "http://localhost/api/basicpages/consent" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: Basic {credentials}"</code></pre>
<pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/basicpages/consent"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "Basic {credentials}",
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
    'http://localhost/api/basicpages/consent',
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
            'Authorization' =&gt; 'Basic {credentials}',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<pre><code class="language-python">import requests
import json

url = 'http://localhost/api/basicpages/consent'
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json',
  'Authorization': 'Basic {credentials}'
}
response = requests.request('GET', url, headers=headers)
response.json()</code></pre>
<h3>HTTP Request</h3>
<p><code>GET api/basicpages/consent</code></p>
<!-- END_06ca21682ebf46506c2c0dc3a1b2b3ed -->
<!-- START_233d479b97574db158472b6e203569cb -->
<h2>api/provider/login</h2>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X POST \
    "http://localhost/api/provider/login" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: Basic {credentials}"</code></pre>
<pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/provider/login"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "Basic {credentials}",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;post(
    'http://localhost/api/provider/login',
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
            'Authorization' =&gt; 'Basic {credentials}',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<pre><code class="language-python">import requests
import json

url = 'http://localhost/api/provider/login'
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json',
  'Authorization': 'Basic {credentials}'
}
response = requests.request('POST', url, headers=headers)
response.json()</code></pre>
<h3>HTTP Request</h3>
<p><code>POST api/provider/login</code></p>
<!-- END_233d479b97574db158472b6e203569cb -->
<!-- START_58f7d26b4be841ae4012f9aee53ca71b -->
<h2>api/provider/reset</h2>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X POST \
    "http://localhost/api/provider/reset" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: Basic {credentials}"</code></pre>
<pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/provider/reset"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "Basic {credentials}",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;post(
    'http://localhost/api/provider/reset',
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
            'Authorization' =&gt; 'Basic {credentials}',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<pre><code class="language-python">import requests
import json

url = 'http://localhost/api/provider/reset'
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json',
  'Authorization': 'Basic {credentials}'
}
response = requests.request('POST', url, headers=headers)
response.json()</code></pre>
<h3>HTTP Request</h3>
<p><code>POST api/provider/reset</code></p>
<!-- END_58f7d26b4be841ae4012f9aee53ca71b -->
<!-- START_a79c2859a661870b229f9a5f8e0cee11 -->
<h2>api/provider/staffs</h2>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "http://localhost/api/provider/staffs" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: Basic {credentials}"</code></pre>
<pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/provider/staffs"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "Basic {credentials}",
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
    'http://localhost/api/provider/staffs',
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
            'Authorization' =&gt; 'Basic {credentials}',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<pre><code class="language-python">import requests
import json

url = 'http://localhost/api/provider/staffs'
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json',
  'Authorization': 'Basic {credentials}'
}
response = requests.request('GET', url, headers=headers)
response.json()</code></pre>
<h3>HTTP Request</h3>
<p><code>GET api/provider/staffs</code></p>
<!-- END_a79c2859a661870b229f9a5f8e0cee11 -->
<!-- START_fd77483b78b187c06f1814384d6d57b3 -->
<h2>api/provider/users/{id}</h2>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "http://localhost/api/provider/users/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: Basic {credentials}"</code></pre>
<pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/provider/users/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "Basic {credentials}",
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
    'http://localhost/api/provider/users/1',
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
            'Authorization' =&gt; 'Basic {credentials}',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<pre><code class="language-python">import requests
import json

url = 'http://localhost/api/provider/users/1'
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json',
  'Authorization': 'Basic {credentials}'
}
response = requests.request('GET', url, headers=headers)
response.json()</code></pre>
<h3>HTTP Request</h3>
<p><code>GET api/provider/users/{id}</code></p>
<!-- END_fd77483b78b187c06f1814384d6d57b3 -->
<!-- START_9fc17ab9176f71634e725de1e2f92e65 -->
<h2>api/provider/users</h2>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "http://localhost/api/provider/users" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: Basic {credentials}"</code></pre>
<pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/provider/users"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "Basic {credentials}",
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
    'http://localhost/api/provider/users',
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
            'Authorization' =&gt; 'Basic {credentials}',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<pre><code class="language-python">import requests
import json

url = 'http://localhost/api/provider/users'
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json',
  'Authorization': 'Basic {credentials}'
}
response = requests.request('GET', url, headers=headers)
response.json()</code></pre>
<h3>HTTP Request</h3>
<p><code>GET api/provider/users</code></p>
<!-- END_9fc17ab9176f71634e725de1e2f92e65 -->
<!-- START_8109a45ec98f00a233d6c20b8a9a1554 -->
<h2>api/provider/clinic</h2>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "http://localhost/api/provider/clinic" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: Basic {credentials}"</code></pre>
<pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/provider/clinic"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "Basic {credentials}",
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
    'http://localhost/api/provider/clinic',
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
            'Authorization' =&gt; 'Basic {credentials}',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<pre><code class="language-python">import requests
import json

url = 'http://localhost/api/provider/clinic'
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json',
  'Authorization': 'Basic {credentials}'
}
response = requests.request('GET', url, headers=headers)
response.json()</code></pre>
<h3>HTTP Request</h3>
<p><code>GET api/provider/clinic</code></p>
<!-- END_8109a45ec98f00a233d6c20b8a9a1554 -->
<!-- START_615660b72e692efee60014889d11fb26 -->
<h2>api/provider/update</h2>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X POST \
    "http://localhost/api/provider/update" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: Basic {credentials}"</code></pre>
<pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/provider/update"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "Basic {credentials}",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<pre><code class="language-php">
$client = new \GuzzleHttp\Client();
$response = $client-&gt;post(
    'http://localhost/api/provider/update',
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
            'Authorization' =&gt; 'Basic {credentials}',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre>
<pre><code class="language-python">import requests
import json

url = 'http://localhost/api/provider/update'
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json',
  'Authorization': 'Basic {credentials}'
}
response = requests.request('POST', url, headers=headers)
response.json()</code></pre>
<h3>HTTP Request</h3>
<p><code>POST api/provider/update</code></p>
<!-- END_615660b72e692efee60014889d11fb26 -->
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
    "http://localhost/api/users/1/fcm_registration_tokens" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: Basic {credentials}" \
    -d '{"registration_id":"fIAe0YS9S1-FyQDlQ24Edu:APA91bF2NDdGgK8UR26uSFvXw2RSXGJ2A1o57f2yh_iDSQ8gYbszgPEcWnanlQCeYO7okp6XNqEVwtjMSVz8RQPNpMtzb4vseRKGov5Wm6PkpK5gDy30SkzrtnjIvCO4nHqTpfmjL2wo"}'
</code></pre>
<pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/users/1/fcm_registration_tokens"
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
    'http://localhost/api/users/1/fcm_registration_tokens',
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

url = 'http://localhost/api/users/1/fcm_registration_tokens'
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
    "http://localhost/api/users/1/fcm_registration_tokens" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: Basic {credentials}" \
    -d '{"registration_id":"fIAe0YS9S1-FyQDlQ24Edu:APA91bF2NDdGgK8UR26uSFvXw2RSXGJ2A1o57f2yh_iDSQ8gYbszgPEcWnanlQCeYO7okp6XNqEVwtjMSVz8RQPNpMtzb4vseRKGov5Wm6PkpK5gDy30SkzrtnjIvCO4nHqTpfmjL2wo"}'
</code></pre>
<pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/users/1/fcm_registration_tokens"
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
    'http://localhost/api/users/1/fcm_registration_tokens',
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

url = 'http://localhost/api/users/1/fcm_registration_tokens'
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