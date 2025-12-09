# Authenticating requests

To authenticate requests, include a **`Cookie`** header with the value **`"XSRF-TOKEN=...; laravel_session=..."`**.

All authenticated endpoints are marked with a `requires authentication` badge in the documentation below.

This API uses Laravel Sanctum SPA authentication, which is <strong>session-based</strong> and does not require API tokens. Make sure your browser and the API share the same top-level domain so Sanctum can manage session cookies.
