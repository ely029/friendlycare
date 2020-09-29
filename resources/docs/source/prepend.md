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
