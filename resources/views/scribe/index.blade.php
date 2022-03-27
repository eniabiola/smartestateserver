<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Laravel Documentation</title>

    <link href="https://fonts.googleapis.com/css?family=PT+Sans&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset("vendor/scribe/css/theme-default.style.css") }}" media="screen">
    <link rel="stylesheet" href="{{ asset("vendor/scribe/css/theme-default.print.css") }}" media="print">
    <script src="{{ asset("vendor/scribe/js/theme-default-3.14.1.js") }}"></script>

    <link rel="stylesheet"
          href="//unpkg.com/@highlightjs/cdn-assets@10.7.2/styles/obsidian.min.css">
    <script src="//unpkg.com/@highlightjs/cdn-assets@10.7.2/highlight.min.js"></script>
    <script>hljs.highlightAll();</script>

    <script src="//cdn.jsdelivr.net/npm/lodash@4.17.10/lodash.min.js"></script>
    <script>
        var baseUrl = "http://smartestateserver.test";
        var useCsrf = Boolean();
        var csrfUrl = "/sanctum/csrf-cookie";
    </script>
    <script src="{{ asset("vendor/scribe/js/tryitout-3.14.1.js") }}"></script>

</head>

<body data-languages="[&quot;bash&quot;,&quot;javascript&quot;]">
<a href="#" id="nav-button">
      <span>
        MENU
        <img src="{{ asset("vendor/scribe/images/navbar.png") }}" alt="navbar-image" />
      </span>
</a>
<div class="tocify-wrapper">
                <div class="lang-selector">
                            <a href="#" data-language-name="bash">bash</a>
                            <a href="#" data-language-name="javascript">javascript</a>
                    </div>
        <div class="search">
        <input type="text" class="search" id="input-search" placeholder="Search">
    </div>
    <ul class="search-results"></ul>

    <ul id="toc">
    </ul>

            <ul class="toc-footer" id="toc-footer">
                            <li><a href="{{ route("scribe.postman") }}">View Postman collection</a></li>
                            <li><a href="{{ route("scribe.openapi") }}">View OpenAPI spec</a></li>
                            <li><a href="http://github.com/knuckleswtf/scribe">Documentation powered by Scribe ✍</a></li>
                    </ul>
            <ul class="toc-footer" id="last-updated">
            <li>Last updated: November 6 2021</li>
        </ul>
</div>
<div class="page-wrapper">
    <div class="dark-box"></div>
    <div class="content">
        <h1>Introduction</h1>
<p>This documentation aims to provide all the information you need to work with our API.</p>
<aside>As you scroll, you'll see code examples for working with the API in different programming languages in the dark area to the right (or as part of the content on mobile).
You can switch the language used with the tabs at the top right (or from the nav menu at the top left on mobile).</aside>
<blockquote>
<p>Base URL</p>
</blockquote>
<pre><code class="language-yaml">http://smartestateserver.test</code></pre>

        <h1>Authenticating requests</h1>
<p>This API is authenticated by sending an <strong><code>Authorization</code></strong> header with the value <strong><code>"Bearer {YOUR_AUTH_KEY}"</code></strong>.</p>
<p>All authenticated endpoints are marked with a <code>requires authentication</code> badge in the documentation below.</p>
<p>You can retrieve your token by visiting your dashboard and clicking <b>Generate API token</b>.</p>

        <h1 id="endpoints">Endpoints</h1>

    

            <h2 id="endpoints-GETapi-docs">GET api/docs</h2>

<p>
</p>



<span id="example-requests-GETapi-docs">
<blockquote>Example request:</blockquote>


<pre><code class="language-bash">curl --request GET \
    --get "http://smartestateserver.test/api/docs" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre>

<pre><code class="language-javascript">const url = new URL(
    "http://smartestateserver.test/api/docs"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
</span>

<span id="example-responses-GETapi-docs">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary>
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
 </code></pre>
        </details>         <pre>

<code class="language-json">&lt;!DOCTYPE html&gt;
&lt;html lang=&quot;en&quot;&gt;
&lt;head&gt;
    &lt;meta charset=&quot;UTF-8&quot;&gt;
    &lt;title&gt;Swagger UI&lt;/title&gt;
    &lt;link href=&quot;https://fonts.googleapis.com/css?family=Open+Sans:400,700|Source+Code+Pro:300,600|Titillium+Web:400,600,700&quot; rel=&quot;stylesheet&quot;&gt;
    &lt;link rel=&quot;stylesheet&quot; type=&quot;text/css&quot; href=&quot;http://smartestateserver.test/vendor/swaggervel/swagger-ui.css&quot; &gt;
    &lt;link rel=&quot;icon&quot; type=&quot;image/png&quot; href=&quot;http://smartestateserver.test/vendor/swaggervel/favicon-32x32.png&quot; sizes=&quot;32x32&quot; /&gt;
    &lt;link rel=&quot;icon&quot; type=&quot;image/png&quot; href=&quot;http://smartestateserver.test/vendor/swaggervel/favicon-16x16.png&quot; sizes=&quot;16x16&quot; /&gt;
    &lt;style&gt;
        html
        {
            box-sizing: border-box;
            overflow: -moz-scrollbars-vertical;
            overflow-y: scroll;
        }
        *,
        *:before,
        *:after
        {
            box-sizing: inherit;
        }

        body {
            margin:0;
            background: #fafafa;
        }
    &lt;/style&gt;
&lt;/head&gt;

&lt;body&gt;

&lt;svg xmlns=&quot;http://www.w3.org/2000/svg&quot; xmlns:xlink=&quot;http://www.w3.org/1999/xlink&quot; style=&quot;position:absolute;width:0;height:0&quot;&gt;
    &lt;defs&gt;
        &lt;symbol viewBox=&quot;0 0 20 20&quot; id=&quot;unlocked&quot;&gt;
            &lt;path d=&quot;M15.8 8H14V5.6C14 2.703 12.665 1 10 1 7.334 1 6 2.703 6 5.6V6h2v-.801C8 3.754 8.797 3 10 3c1.203 0 2 .754 2 2.199V8H4c-.553 0-1 .646-1 1.199V17c0 .549.428 1.139.951 1.307l1.197.387C5.672 18.861 6.55 19 7.1 19h5.8c.549 0 1.428-.139 1.951-.307l1.196-.387c.524-.167.953-.757.953-1.306V9.199C17 8.646 16.352 8 15.8 8z&quot;&gt;&lt;/path&gt;
        &lt;/symbol&gt;

        &lt;symbol viewBox=&quot;0 0 20 20&quot; id=&quot;locked&quot;&gt;
            &lt;path d=&quot;M15.8 8H14V5.6C14 2.703 12.665 1 10 1 7.334 1 6 2.703 6 5.6V8H4c-.553 0-1 .646-1 1.199V17c0 .549.428 1.139.951 1.307l1.197.387C5.672 18.861 6.55 19 7.1 19h5.8c.549 0 1.428-.139 1.951-.307l1.196-.387c.524-.167.953-.757.953-1.306V9.199C17 8.646 16.352 8 15.8 8zM12 8H8V5.199C8 3.754 8.797 3 10 3c1.203 0 2 .754 2 2.199V8z&quot;/&gt;
        &lt;/symbol&gt;

        &lt;symbol viewBox=&quot;0 0 20 20&quot; id=&quot;close&quot;&gt;
            &lt;path d=&quot;M14.348 14.849c-.469.469-1.229.469-1.697 0L10 11.819l-2.651 3.029c-.469.469-1.229.469-1.697 0-.469-.469-.469-1.229 0-1.697l2.758-3.15-2.759-3.152c-.469-.469-.469-1.228 0-1.697.469-.469 1.228-.469 1.697 0L10 8.183l2.651-3.031c.469-.469 1.228-.469 1.697 0 .469.469.469 1.229 0 1.697l-2.758 3.152 2.758 3.15c.469.469.469 1.229 0 1.698z&quot;/&gt;
        &lt;/symbol&gt;

        &lt;symbol viewBox=&quot;0 0 20 20&quot; id=&quot;large-arrow&quot;&gt;
            &lt;path d=&quot;M13.25 10L6.109 2.58c-.268-.27-.268-.707 0-.979.268-.27.701-.27.969 0l7.83 7.908c.268.271.268.709 0 .979l-7.83 7.908c-.268.271-.701.27-.969 0-.268-.269-.268-.707 0-.979L13.25 10z&quot;/&gt;
        &lt;/symbol&gt;

        &lt;symbol viewBox=&quot;0 0 20 20&quot; id=&quot;large-arrow-down&quot;&gt;
            &lt;path d=&quot;M17.418 6.109c.272-.268.709-.268.979 0s.271.701 0 .969l-7.908 7.83c-.27.268-.707.268-.979 0l-7.908-7.83c-.27-.268-.27-.701 0-.969.271-.268.709-.268.979 0L10 13.25l7.418-7.141z&quot;/&gt;
        &lt;/symbol&gt;


        &lt;symbol viewBox=&quot;0 0 24 24&quot; id=&quot;jump-to&quot;&gt;
            &lt;path d=&quot;M19 7v4H5.83l3.58-3.59L8 6l-6 6 6 6 1.41-1.41L5.83 13H21V7z&quot;/&gt;
        &lt;/symbol&gt;

        &lt;symbol viewBox=&quot;0 0 24 24&quot; id=&quot;expand&quot;&gt;
            &lt;path d=&quot;M10 18h4v-2h-4v2zM3 6v2h18V6H3zm3 7h12v-2H6v2z&quot;/&gt;
        &lt;/symbol&gt;

    &lt;/defs&gt;
&lt;/svg&gt;

&lt;div id=&quot;swagger-ui&quot;&gt;&lt;/div&gt;

&lt;script src=&quot;http://smartestateserver.test/vendor/swaggervel/swagger-ui-bundle.js&quot;&gt;&lt;/script&gt;
&lt;script src=&quot;http://smartestateserver.test/vendor/swaggervel/swagger-ui-standalone-preset.js&quot;&gt;&lt;/script&gt;
&lt;script&gt;

    window.onload = function () {
        // Build a system
        const ui = SwaggerUIBundle({
            url: 'http://smartestateserver.test/docs',
            dom_id: '#swagger-ui',
            deepLinking: true,
            presets: [
                SwaggerUIBundle.presets.apis,
                SwaggerUIStandalonePreset
            ],
            plugins: [
                SwaggerUIBundle.plugins.DownloadUrl
            ],
            layout: &quot;StandaloneLayout&quot;
        });

        
        window.ui = ui;
    }
&lt;/script&gt;
&lt;/body&gt;

&lt;/html&gt;
</code>
 </pre>
    </span>
<span id="execution-results-GETapi-docs" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-docs"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-docs"></code></pre>
</span>
<span id="execution-error-GETapi-docs" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-docs"></code></pre>
</span>
<form id="form-GETapi-docs" data-method="GET"
      data-path="api/docs"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-docs', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-docs"
                    onclick="tryItOut('GETapi-docs');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-docs"
                    onclick="cancelTryOut('GETapi-docs');" hidden>Cancel
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-docs" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/docs</code></b>
        </p>
                    </form>

            <h2 id="endpoints-POSTapi-login">POST api/login</h2>

<p>
</p>



<span id="example-requests-POSTapi-login">
<blockquote>Example request:</blockquote>


<pre><code class="language-bash">curl --request POST \
    "http://smartestateserver.test/api/login" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre>

<pre><code class="language-javascript">const url = new URL(
    "http://smartestateserver.test/api/login"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers,
}).then(response =&gt; response.json());</code></pre>
</span>

<span id="example-responses-POSTapi-login">
</span>
<span id="execution-results-POSTapi-login" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-login"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-login"></code></pre>
</span>
<span id="execution-error-POSTapi-login" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-login"></code></pre>
</span>
<form id="form-POSTapi-login" data-method="POST"
      data-path="api/login"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-login', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-login"
                    onclick="tryItOut('POSTapi-login');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-login"
                    onclick="cancelTryOut('POSTapi-login');" hidden>Cancel
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-login" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/login</code></b>
        </p>
                    </form>

            <h2 id="endpoints-POSTapi-register">POST api/register</h2>

<p>
</p>



<span id="example-requests-POSTapi-register">
<blockquote>Example request:</blockquote>


<pre><code class="language-bash">curl --request POST \
    "http://smartestateserver.test/api/register" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"surname\": \"est\",
    \"othernames\": \"accusamus\",
    \"phone\": \"aliquid\",
    \"gender\": \"tenetur\",
    \"email\": \"bbode@example.com\",
    \"password\": \"mgvlipyrgizb\"
}"
</code></pre>

<pre><code class="language-javascript">const url = new URL(
    "http://smartestateserver.test/api/register"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "surname": "est",
    "othernames": "accusamus",
    "phone": "aliquid",
    "gender": "tenetur",
    "email": "bbode@example.com",
    "password": "mgvlipyrgizb"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre>
</span>

<span id="example-responses-POSTapi-register">
</span>
<span id="execution-results-POSTapi-register" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-register"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-register"></code></pre>
</span>
<span id="execution-error-POSTapi-register" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-register"></code></pre>
</span>
<form id="form-POSTapi-register" data-method="POST"
      data-path="api/register"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-register', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-register"
                    onclick="tryItOut('POSTapi-register');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-register"
                    onclick="cancelTryOut('POSTapi-register');" hidden>Cancel
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-register" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/register</code></b>
        </p>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <p>
            <b><code>surname</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
                <input type="text"
               name="surname"
               data-endpoint="POSTapi-register"
               value="est"
               data-component="body" hidden>
    <br>

        </p>
                <p>
            <b><code>othernames</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
                <input type="text"
               name="othernames"
               data-endpoint="POSTapi-register"
               value="accusamus"
               data-component="body" hidden>
    <br>

        </p>
                <p>
            <b><code>phone</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
                <input type="text"
               name="phone"
               data-endpoint="POSTapi-register"
               value="aliquid"
               data-component="body" hidden>
    <br>

        </p>
                <p>
            <b><code>gender</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
                <input type="text"
               name="gender"
               data-endpoint="POSTapi-register"
               value="tenetur"
               data-component="body" hidden>
    <br>

        </p>
                <p>
            <b><code>email</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
                <input type="text"
               name="email"
               data-endpoint="POSTapi-register"
               value="bbode@example.com"
               data-component="body" hidden>
    <br>
<p>Must be a valid email address.</p>
        </p>
                <p>
            <b><code>password</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
                <input type="text"
               name="password"
               data-endpoint="POSTapi-register"
               value="mgvlipyrgizb"
               data-component="body" hidden>
    <br>
<p>Must be at least 6 characters. Must not be greater than 50 characters.</p>
        </p>
        </form>

            <h2 id="endpoints-GETapi-logout">GET api/logout</h2>

<p>
</p>



<span id="example-requests-GETapi-logout">
<blockquote>Example request:</blockquote>


<pre><code class="language-bash">curl --request GET \
    --get "http://smartestateserver.test/api/logout" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"token\": \"illum\"
}"
</code></pre>

<pre><code class="language-javascript">const url = new URL(
    "http://smartestateserver.test/api/logout"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "token": "illum"
};

fetch(url, {
    method: "GET",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre>
</span>

<span id="example-responses-GETapi-logout">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary>
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 58
access-control-allow-origin: *
 </code></pre>
        </details>         <pre>

<code class="language-json">{
    &quot;status&quot;: &quot;Token is Invalid&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-logout" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-logout"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-logout"></code></pre>
</span>
<span id="execution-error-GETapi-logout" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-logout"></code></pre>
</span>
<form id="form-GETapi-logout" data-method="GET"
      data-path="api/logout"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-logout', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-logout"
                    onclick="tryItOut('GETapi-logout');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-logout"
                    onclick="cancelTryOut('GETapi-logout');" hidden>Cancel
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-logout" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/logout</code></b>
        </p>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <p>
            <b><code>token</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
                <input type="text"
               name="token"
               data-endpoint="GETapi-logout"
               value="illum"
               data-component="body" hidden>
    <br>

        </p>
        </form>

            <h2 id="endpoints-GETapi-users">Display a listing of the User.</h2>

<p>
</p>

<p>GET|HEAD /users</p>

<span id="example-requests-GETapi-users">
<blockquote>Example request:</blockquote>


<pre><code class="language-bash">curl --request GET \
    --get "http://smartestateserver.test/api/users" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre>

<pre><code class="language-javascript">const url = new URL(
    "http://smartestateserver.test/api/users"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
</span>

<span id="example-responses-GETapi-users">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary>
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 57
access-control-allow-origin: *
 </code></pre>
        </details>         <pre>

<code class="language-json">{
    &quot;status&quot;: &quot;Authorization Token not found&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-users" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-users"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-users"></code></pre>
</span>
<span id="execution-error-GETapi-users" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-users"></code></pre>
</span>
<form id="form-GETapi-users" data-method="GET"
      data-path="api/users"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-users', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-users"
                    onclick="tryItOut('GETapi-users');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-users"
                    onclick="cancelTryOut('GETapi-users');" hidden>Cancel
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-users" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/users</code></b>
        </p>
                    </form>

            <h2 id="endpoints-POSTapi-users">Store a newly created User in storage.</h2>

<p>
</p>

<p>POST /users</p>

<span id="example-requests-POSTapi-users">
<blockquote>Example request:</blockquote>


<pre><code class="language-bash">curl --request POST \
    "http://smartestateserver.test/api/users" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"surname\": \"ygskjrkdyallxvkrdaigwlrgbbthihsobbbhbpdsnmexakexnnwmepsfolp\",
    \"othernames\": \"lxdckhpenojvamyzpkinyloqxpqwpkbhx\",
    \"phone\": \"v\",
    \"gender\": \"nulla\",
    \"email\": \"mmaiyhtbepntfwuceklakefcppcqeqsamkxnxoffwcgklnqhmgevxdxjebzosgzqyjgbynybbdrewzrncerpbellxtnjevinlipvhxvedqrozpndaviuigfnzetwrblrvmahsjwsaeocyjiaqfkczgwybadteatxrnodlcqrymkgsefpuplmtedwwmnmohuhytnzyplnqknvudiupbkaqfingwynljlpkmtq\",
    \"remember_token\": \"pbmpcqootjgzzebxuorcguhhknvkojqmqfujgqkjvmffsevyyztnoazoagzeolthshohptwlzqfylvrlhadakogtkdmdpkkczc\",
    \"role_id\": \"illo\"
}"
</code></pre>

<pre><code class="language-javascript">const url = new URL(
    "http://smartestateserver.test/api/users"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "surname": "ygskjrkdyallxvkrdaigwlrgbbthihsobbbhbpdsnmexakexnnwmepsfolp",
    "othernames": "lxdckhpenojvamyzpkinyloqxpqwpkbhx",
    "phone": "v",
    "gender": "nulla",
    "email": "mmaiyhtbepntfwuceklakefcppcqeqsamkxnxoffwcgklnqhmgevxdxjebzosgzqyjgbynybbdrewzrncerpbellxtnjevinlipvhxvedqrozpndaviuigfnzetwrblrvmahsjwsaeocyjiaqfkczgwybadteatxrnodlcqrymkgsefpuplmtedwwmnmohuhytnzyplnqknvudiupbkaqfingwynljlpkmtq",
    "remember_token": "pbmpcqootjgzzebxuorcguhhknvkojqmqfujgqkjvmffsevyyztnoazoagzeolthshohptwlzqfylvrlhadakogtkdmdpkkczc",
    "role_id": "illo"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre>
</span>

<span id="example-responses-POSTapi-users">
</span>
<span id="execution-results-POSTapi-users" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-users"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-users"></code></pre>
</span>
<span id="execution-error-POSTapi-users" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-users"></code></pre>
</span>
<form id="form-POSTapi-users" data-method="POST"
      data-path="api/users"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-users', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-users"
                    onclick="tryItOut('POSTapi-users');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-users"
                    onclick="cancelTryOut('POSTapi-users');" hidden>Cancel
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-users" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/users</code></b>
        </p>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <p>
            <b><code>surname</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
                <input type="text"
               name="surname"
               data-endpoint="POSTapi-users"
               value="ygskjrkdyallxvkrdaigwlrgbbthihsobbbhbpdsnmexakexnnwmepsfolp"
               data-component="body" hidden>
    <br>
<p>Must not be greater than 100 characters.</p>
        </p>
                <p>
            <b><code>othernames</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
                <input type="text"
               name="othernames"
               data-endpoint="POSTapi-users"
               value="lxdckhpenojvamyzpkinyloqxpqwpkbhx"
               data-component="body" hidden>
    <br>
<p>Must not be greater than 100 characters.</p>
        </p>
                <p>
            <b><code>phone</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
                <input type="text"
               name="phone"
               data-endpoint="POSTapi-users"
               value="v"
               data-component="body" hidden>
    <br>
<p>Must not be greater than 14 characters.</p>
        </p>
                <p>
            <b><code>gender</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
                <input type="text"
               name="gender"
               data-endpoint="POSTapi-users"
               value="nulla"
               data-component="body" hidden>
    <br>

        </p>
                <p>
            <b><code>email</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
                <input type="text"
               name="email"
               data-endpoint="POSTapi-users"
               value="mmaiyhtbepntfwuceklakefcppcqeqsamkxnxoffwcgklnqhmgevxdxjebzosgzqyjgbynybbdrewzrncerpbellxtnjevinlipvhxvedqrozpndaviuigfnzetwrblrvmahsjwsaeocyjiaqfkczgwybadteatxrnodlcqrymkgsefpuplmtedwwmnmohuhytnzyplnqknvudiupbkaqfingwynljlpkmtq"
               data-component="body" hidden>
    <br>
<p>Must not be greater than 255 characters.</p>
        </p>
                <p>
            <b><code>remember_token</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
                <input type="text"
               name="remember_token"
               data-endpoint="POSTapi-users"
               value="pbmpcqootjgzzebxuorcguhhknvkojqmqfujgqkjvmffsevyyztnoazoagzeolthshohptwlzqfylvrlhadakogtkdmdpkkczc"
               data-component="body" hidden>
    <br>
<p>Must not be greater than 100 characters.</p>
        </p>
                <p>
            <b><code>created_at</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
                <input type="text"
               name="created_at"
               data-endpoint="POSTapi-users"
               value=""
               data-component="body" hidden>
    <br>

        </p>
                <p>
            <b><code>updated_at</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
                <input type="text"
               name="updated_at"
               data-endpoint="POSTapi-users"
               value=""
               data-component="body" hidden>
    <br>

        </p>
                <p>
            <b><code>role_id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
                <input type="text"
               name="role_id"
               data-endpoint="POSTapi-users"
               value="illo"
               data-component="body" hidden>
    <br>

        </p>
        </form>

            <h2 id="endpoints-GETapi-users--id-">Display the specified User.</h2>

<p>
</p>

<p>GET|HEAD /users/{id}</p>

<span id="example-requests-GETapi-users--id-">
<blockquote>Example request:</blockquote>


<pre><code class="language-bash">curl --request GET \
    --get "http://smartestateserver.test/api/users/15" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre>

<pre><code class="language-javascript">const url = new URL(
    "http://smartestateserver.test/api/users/15"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
</span>

<span id="example-responses-GETapi-users--id-">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary>
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 56
access-control-allow-origin: *
 </code></pre>
        </details>         <pre>

<code class="language-json">{
    &quot;status&quot;: &quot;Authorization Token not found&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-users--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-users--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-users--id-"></code></pre>
</span>
<span id="execution-error-GETapi-users--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-users--id-"></code></pre>
</span>
<form id="form-GETapi-users--id-" data-method="GET"
      data-path="api/users/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-users--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-users--id-"
                    onclick="tryItOut('GETapi-users--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-users--id-"
                    onclick="cancelTryOut('GETapi-users--id-');" hidden>Cancel
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-users--id-" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/users/{id}</code></b>
        </p>
                    <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <p>
                <b><code>id</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
                <input type="number"
               name="id"
               data-endpoint="GETapi-users--id-"
               value="15"
               data-component="url" hidden>
    <br>
<p>The ID of the user.</p>
            </p>
                    </form>

            <h2 id="endpoints-PUTapi-users--id-">Update the specified User in storage.</h2>

<p>
</p>

<p>PUT/PATCH /users/{id}</p>

<span id="example-requests-PUTapi-users--id-">
<blockquote>Example request:</blockquote>


<pre><code class="language-bash">curl --request PUT \
    "http://smartestateserver.test/api/users/8" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"surname\": \"irskwnqserztmndfwduvkwbffcabxroowdhutztartxnyptllswsledjrpstspsofkxyyoenwzhjb\",
    \"othernames\": \"uczrjxqvxtnuufkxgaeuihbrqycwqhj\",
    \"phone\": \"upefz\",
    \"gender\": \"qui\",
    \"email\": \"vojoelcflkxfeuqtflksymtxgqameqpjznnluntnqroluscdofhdgkrd\",
    \"remember_token\": \"oawsadslgmq\"
}"
</code></pre>

<pre><code class="language-javascript">const url = new URL(
    "http://smartestateserver.test/api/users/8"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "surname": "irskwnqserztmndfwduvkwbffcabxroowdhutztartxnyptllswsledjrpstspsofkxyyoenwzhjb",
    "othernames": "uczrjxqvxtnuufkxgaeuihbrqycwqhj",
    "phone": "upefz",
    "gender": "qui",
    "email": "vojoelcflkxfeuqtflksymtxgqameqpjznnluntnqroluscdofhdgkrd",
    "remember_token": "oawsadslgmq"
};

fetch(url, {
    method: "PUT",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre>
</span>

<span id="example-responses-PUTapi-users--id-">
</span>
<span id="execution-results-PUTapi-users--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-PUTapi-users--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-users--id-"></code></pre>
</span>
<span id="execution-error-PUTapi-users--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-users--id-"></code></pre>
</span>
<form id="form-PUTapi-users--id-" data-method="PUT"
      data-path="api/users/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('PUTapi-users--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-PUTapi-users--id-"
                    onclick="tryItOut('PUTapi-users--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-PUTapi-users--id-"
                    onclick="cancelTryOut('PUTapi-users--id-');" hidden>Cancel
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-PUTapi-users--id-" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-darkblue">PUT</small>
            <b><code>api/users/{id}</code></b>
        </p>
            <p>
            <small class="badge badge-purple">PATCH</small>
            <b><code>api/users/{id}</code></b>
        </p>
                    <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <p>
                <b><code>id</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
                <input type="number"
               name="id"
               data-endpoint="PUTapi-users--id-"
               value="8"
               data-component="url" hidden>
    <br>
<p>The ID of the user.</p>
            </p>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <p>
            <b><code>surname</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
                <input type="text"
               name="surname"
               data-endpoint="PUTapi-users--id-"
               value="irskwnqserztmndfwduvkwbffcabxroowdhutztartxnyptllswsledjrpstspsofkxyyoenwzhjb"
               data-component="body" hidden>
    <br>
<p>Must not be greater than 100 characters.</p>
        </p>
                <p>
            <b><code>othernames</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
                <input type="text"
               name="othernames"
               data-endpoint="PUTapi-users--id-"
               value="uczrjxqvxtnuufkxgaeuihbrqycwqhj"
               data-component="body" hidden>
    <br>
<p>Must not be greater than 100 characters.</p>
        </p>
                <p>
            <b><code>phone</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
                <input type="text"
               name="phone"
               data-endpoint="PUTapi-users--id-"
               value="upefz"
               data-component="body" hidden>
    <br>
<p>Must not be greater than 14 characters.</p>
        </p>
                <p>
            <b><code>gender</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
                <input type="text"
               name="gender"
               data-endpoint="PUTapi-users--id-"
               value="qui"
               data-component="body" hidden>
    <br>

        </p>
                <p>
            <b><code>email</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
                <input type="text"
               name="email"
               data-endpoint="PUTapi-users--id-"
               value="vojoelcflkxfeuqtflksymtxgqameqpjznnluntnqroluscdofhdgkrd"
               data-component="body" hidden>
    <br>
<p>Must not be greater than 255 characters.</p>
        </p>
                <p>
            <b><code>remember_token</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
                <input type="text"
               name="remember_token"
               data-endpoint="PUTapi-users--id-"
               value="oawsadslgmq"
               data-component="body" hidden>
    <br>
<p>Must not be greater than 100 characters.</p>
        </p>
                <p>
            <b><code>created_at</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
                <input type="text"
               name="created_at"
               data-endpoint="PUTapi-users--id-"
               value=""
               data-component="body" hidden>
    <br>

        </p>
                <p>
            <b><code>updated_at</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
                <input type="text"
               name="updated_at"
               data-endpoint="PUTapi-users--id-"
               value=""
               data-component="body" hidden>
    <br>

        </p>
        </form>

            <h2 id="endpoints-DELETEapi-users--id-">Remove the specified User from storage.</h2>

<p>
</p>

<p>DELETE /users/{id}</p>

<span id="example-requests-DELETEapi-users--id-">
<blockquote>Example request:</blockquote>


<pre><code class="language-bash">curl --request DELETE \
    "http://smartestateserver.test/api/users/10" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre>

<pre><code class="language-javascript">const url = new URL(
    "http://smartestateserver.test/api/users/10"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers,
}).then(response =&gt; response.json());</code></pre>
</span>

<span id="example-responses-DELETEapi-users--id-">
</span>
<span id="execution-results-DELETEapi-users--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-DELETEapi-users--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-users--id-"></code></pre>
</span>
<span id="execution-error-DELETEapi-users--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-users--id-"></code></pre>
</span>
<form id="form-DELETEapi-users--id-" data-method="DELETE"
      data-path="api/users/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('DELETEapi-users--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-DELETEapi-users--id-"
                    onclick="tryItOut('DELETEapi-users--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-DELETEapi-users--id-"
                    onclick="cancelTryOut('DELETEapi-users--id-');" hidden>Cancel
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-DELETEapi-users--id-" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-red">DELETE</small>
            <b><code>api/users/{id}</code></b>
        </p>
                    <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <p>
                <b><code>id</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
                <input type="number"
               name="id"
               data-endpoint="DELETEapi-users--id-"
               value="10"
               data-component="url" hidden>
    <br>
<p>The ID of the user.</p>
            </p>
                    </form>

            <h2 id="endpoints-GETapi-estates">Display a listing of the Estate.</h2>

<p>
</p>

<p>GET|HEAD /estates</p>

<span id="example-requests-GETapi-estates">
<blockquote>Example request:</blockquote>


<pre><code class="language-bash">curl --request GET \
    --get "http://smartestateserver.test/api/estates" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre>

<pre><code class="language-javascript">const url = new URL(
    "http://smartestateserver.test/api/estates"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
</span>

<span id="example-responses-GETapi-estates">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary>
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 55
access-control-allow-origin: *
 </code></pre>
        </details>         <pre>

<code class="language-json">{
    &quot;status&quot;: &quot;Authorization Token not found&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-estates" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-estates"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-estates"></code></pre>
</span>
<span id="execution-error-GETapi-estates" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-estates"></code></pre>
</span>
<form id="form-GETapi-estates" data-method="GET"
      data-path="api/estates"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-estates', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-estates"
                    onclick="tryItOut('GETapi-estates');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-estates"
                    onclick="cancelTryOut('GETapi-estates');" hidden>Cancel
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-estates" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/estates</code></b>
        </p>
                    </form>

            <h2 id="endpoints-POSTapi-estates">Store a newly created Estate in storage.</h2>

<p>
</p>

<p>POST /estates</p>

<span id="example-requests-POSTapi-estates">
<blockquote>Example request:</blockquote>


<pre><code class="language-bash">curl --request POST \
    "http://smartestateserver.test/api/estates" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"city_id\": 9,
    \"state_id\": 2,
    \"bank_id\": 1,
    \"email\": \"fbesebgtosyedovusjpszwbesviqcjhvanfqfiqepskjyceddrxhevoyxovvryixfbvhfaytvrenbbldiewk\",
    \"phone\": \"hqhviobsoydg\",
    \"address\": \"crkwijmzubltwqscehbcugtmexsmaakevfxqxfnoyllmgpkceugtsncuelzxcetwfaphhzqktcwrzxykqkfulptupfcnx\",
    \"accountNumber\": \"gwchnio\",
    \"accountName\": \"bmuprpyshpsii\",
    \"accountVerified\": true,
    \"alternateEmail\": \"mqtuxbxbjzbdrhtsmqykxtpkhztxol\",
    \"alternatePhone\": \"oxjwa\",
    \"created_by\": 9,
    \"name\": \"vvhqrmefznncqjdlky\"
}"
</code></pre>

<pre><code class="language-javascript">const url = new URL(
    "http://smartestateserver.test/api/estates"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "city_id": 9,
    "state_id": 2,
    "bank_id": 1,
    "email": "fbesebgtosyedovusjpszwbesviqcjhvanfqfiqepskjyceddrxhevoyxovvryixfbvhfaytvrenbbldiewk",
    "phone": "hqhviobsoydg",
    "address": "crkwijmzubltwqscehbcugtmexsmaakevfxqxfnoyllmgpkceugtsncuelzxcetwfaphhzqktcwrzxykqkfulptupfcnx",
    "accountNumber": "gwchnio",
    "accountName": "bmuprpyshpsii",
    "accountVerified": true,
    "alternateEmail": "mqtuxbxbjzbdrhtsmqykxtpkhztxol",
    "alternatePhone": "oxjwa",
    "created_by": 9,
    "name": "vvhqrmefznncqjdlky"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre>
</span>

<span id="example-responses-POSTapi-estates">
</span>
<span id="execution-results-POSTapi-estates" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-estates"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-estates"></code></pre>
</span>
<span id="execution-error-POSTapi-estates" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-estates"></code></pre>
</span>
<form id="form-POSTapi-estates" data-method="POST"
      data-path="api/estates"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-estates', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-estates"
                    onclick="tryItOut('POSTapi-estates');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-estates"
                    onclick="cancelTryOut('POSTapi-estates');" hidden>Cancel
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-estates" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/estates</code></b>
        </p>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <p>
            <b><code>city_id</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
                <input type="number"
               name="city_id"
               data-endpoint="POSTapi-estates"
               value="9"
               data-component="body" hidden>
    <br>

        </p>
                <p>
            <b><code>state_id</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
                <input type="number"
               name="state_id"
               data-endpoint="POSTapi-estates"
               value="2"
               data-component="body" hidden>
    <br>

        </p>
                <p>
            <b><code>bank_id</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
                <input type="number"
               name="bank_id"
               data-endpoint="POSTapi-estates"
               value="1"
               data-component="body" hidden>
    <br>

        </p>
                <p>
            <b><code>email</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
                <input type="text"
               name="email"
               data-endpoint="POSTapi-estates"
               value="fbesebgtosyedovusjpszwbesviqcjhvanfqfiqepskjyceddrxhevoyxovvryixfbvhfaytvrenbbldiewk"
               data-component="body" hidden>
    <br>
<p>Must not be greater than 100 characters.</p>
        </p>
                <p>
            <b><code>phone</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
                <input type="text"
               name="phone"
               data-endpoint="POSTapi-estates"
               value="hqhviobsoydg"
               data-component="body" hidden>
    <br>
<p>Must not be greater than 17 characters.</p>
        </p>
                <p>
            <b><code>address</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
                <input type="text"
               name="address"
               data-endpoint="POSTapi-estates"
               value="crkwijmzubltwqscehbcugtmexsmaakevfxqxfnoyllmgpkceugtsncuelzxcetwfaphhzqktcwrzxykqkfulptupfcnx"
               data-component="body" hidden>
    <br>
<p>Must not be greater than 255 characters.</p>
        </p>
                <p>
            <b><code>accountNumber</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
                <input type="text"
               name="accountNumber"
               data-endpoint="POSTapi-estates"
               value="gwchnio"
               data-component="body" hidden>
    <br>
<p>Must not be greater than 12 characters.</p>
        </p>
                <p>
            <b><code>accountName</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
                <input type="text"
               name="accountName"
               data-endpoint="POSTapi-estates"
               value="bmuprpyshpsii"
               data-component="body" hidden>
    <br>
<p>Must not be greater than 100 characters.</p>
        </p>
                <p>
            <b><code>imageName</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
                <input type="text"
               name="imageName"
               data-endpoint="POSTapi-estates"
               value=""
               data-component="body" hidden>
    <br>

        </p>
                <p>
            <b><code>accountVerified</code></b>&nbsp;&nbsp;<small>boolean</small>  &nbsp;
                <label data-endpoint="POSTapi-estates" hidden>
            <input type="radio" name="accountVerified"
                   value="true"
                   data-endpoint="POSTapi-estates"
                   data-component="body"
            >
            <code>true</code>
        </label>
        <label data-endpoint="POSTapi-estates" hidden>
            <input type="radio" name="accountVerified"
                   value="false"
                   data-endpoint="POSTapi-estates"
                   data-component="body"
            >
            <code>false</code>
        </label>
    <br>

        </p>
                <p>
            <b><code>alternateEmail</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
                <input type="text"
               name="alternateEmail"
               data-endpoint="POSTapi-estates"
               value="mqtuxbxbjzbdrhtsmqykxtpkhztxol"
               data-component="body" hidden>
    <br>
<p>Must not be greater than 100 characters.</p>
        </p>
                <p>
            <b><code>alternatePhone</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
                <input type="text"
               name="alternatePhone"
               data-endpoint="POSTapi-estates"
               value="oxjwa"
               data-component="body" hidden>
    <br>
<p>Must not be greater than 17 characters.</p>
        </p>
                <p>
            <b><code>created_by</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
                <input type="number"
               name="created_by"
               data-endpoint="POSTapi-estates"
               value="9"
               data-component="body" hidden>
    <br>

        </p>
                <p>
            <b><code>name</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
                <input type="text"
               name="name"
               data-endpoint="POSTapi-estates"
               value="vvhqrmefznncqjdlky"
               data-component="body" hidden>
    <br>
<p>Must not be greater than 100 characters.</p>
        </p>
        </form>

            <h2 id="endpoints-GETapi-estates--id-">Display the specified Estate.</h2>

<p>
</p>

<p>GET|HEAD /estates/{id}</p>

<span id="example-requests-GETapi-estates--id-">
<blockquote>Example request:</blockquote>


<pre><code class="language-bash">curl --request GET \
    --get "http://smartestateserver.test/api/estates/4" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre>

<pre><code class="language-javascript">const url = new URL(
    "http://smartestateserver.test/api/estates/4"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
</span>

<span id="example-responses-GETapi-estates--id-">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary>
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 54
access-control-allow-origin: *
 </code></pre>
        </details>         <pre>

<code class="language-json">{
    &quot;status&quot;: &quot;Authorization Token not found&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-estates--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-estates--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-estates--id-"></code></pre>
</span>
<span id="execution-error-GETapi-estates--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-estates--id-"></code></pre>
</span>
<form id="form-GETapi-estates--id-" data-method="GET"
      data-path="api/estates/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-estates--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-estates--id-"
                    onclick="tryItOut('GETapi-estates--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-estates--id-"
                    onclick="cancelTryOut('GETapi-estates--id-');" hidden>Cancel
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-estates--id-" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/estates/{id}</code></b>
        </p>
                    <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <p>
                <b><code>id</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
                <input type="number"
               name="id"
               data-endpoint="GETapi-estates--id-"
               value="4"
               data-component="url" hidden>
    <br>
<p>The ID of the estate.</p>
            </p>
                    </form>

            <h2 id="endpoints-PUTapi-estates--id-">Update the specified Estate in storage.</h2>

<p>
</p>

<p>PUT/PATCH /estates/{id}</p>

<span id="example-requests-PUTapi-estates--id-">
<blockquote>Example request:</blockquote>


<pre><code class="language-bash">curl --request PUT \
    "http://smartestateserver.test/api/estates/17" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"city_id\": 2,
    \"state_id\": 8,
    \"bank_id\": 8,
    \"email\": \"lrbzdiukvjuvkinggksyyfrlncgxpqdtavrnfnielszxqlkefujshuzyqwrfbmuslqxckgndrsltfgwf\",
    \"phone\": \"amoipcwhe\",
    \"address\": \"mxvdvgjvuoaajszdvgddwsmrwqfguuyaklhhqsmxsxmnmjxebfsvexityhhpkwfjuqkqsxehrkrhlupgxrhrvthewwinflsaokzqcnnfsjpqvadvwwvvexxpthtwscrdngguyxawygfxmkpoerjwtepvizwkjbxfpbbjwemarhgrk\",
    \"accountNumber\": \"l\",
    \"accountName\": \"xtfi\",
    \"accountVerified\": false,
    \"alternateEmail\": \"twmqpvoojclbepkvfhydlkobgsbtzr\",
    \"alternatePhone\": \"wkndfdapx\",
    \"created_by\": 17,
    \"name\": \"xrsxftawekcwcrftlkedjrpfmuhmufwyyyhuunaxghoamhh\"
}"
</code></pre>

<pre><code class="language-javascript">const url = new URL(
    "http://smartestateserver.test/api/estates/17"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "city_id": 2,
    "state_id": 8,
    "bank_id": 8,
    "email": "lrbzdiukvjuvkinggksyyfrlncgxpqdtavrnfnielszxqlkefujshuzyqwrfbmuslqxckgndrsltfgwf",
    "phone": "amoipcwhe",
    "address": "mxvdvgjvuoaajszdvgddwsmrwqfguuyaklhhqsmxsxmnmjxebfsvexityhhpkwfjuqkqsxehrkrhlupgxrhrvthewwinflsaokzqcnnfsjpqvadvwwvvexxpthtwscrdngguyxawygfxmkpoerjwtepvizwkjbxfpbbjwemarhgrk",
    "accountNumber": "l",
    "accountName": "xtfi",
    "accountVerified": false,
    "alternateEmail": "twmqpvoojclbepkvfhydlkobgsbtzr",
    "alternatePhone": "wkndfdapx",
    "created_by": 17,
    "name": "xrsxftawekcwcrftlkedjrpfmuhmufwyyyhuunaxghoamhh"
};

fetch(url, {
    method: "PUT",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre>
</span>

<span id="example-responses-PUTapi-estates--id-">
</span>
<span id="execution-results-PUTapi-estates--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-PUTapi-estates--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-estates--id-"></code></pre>
</span>
<span id="execution-error-PUTapi-estates--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-estates--id-"></code></pre>
</span>
<form id="form-PUTapi-estates--id-" data-method="PUT"
      data-path="api/estates/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('PUTapi-estates--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-PUTapi-estates--id-"
                    onclick="tryItOut('PUTapi-estates--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-PUTapi-estates--id-"
                    onclick="cancelTryOut('PUTapi-estates--id-');" hidden>Cancel
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-PUTapi-estates--id-" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-darkblue">PUT</small>
            <b><code>api/estates/{id}</code></b>
        </p>
            <p>
            <small class="badge badge-purple">PATCH</small>
            <b><code>api/estates/{id}</code></b>
        </p>
                    <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <p>
                <b><code>id</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
                <input type="number"
               name="id"
               data-endpoint="PUTapi-estates--id-"
               value="17"
               data-component="url" hidden>
    <br>
<p>The ID of the estate.</p>
            </p>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <p>
            <b><code>city_id</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
                <input type="number"
               name="city_id"
               data-endpoint="PUTapi-estates--id-"
               value="2"
               data-component="body" hidden>
    <br>

        </p>
                <p>
            <b><code>state_id</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
                <input type="number"
               name="state_id"
               data-endpoint="PUTapi-estates--id-"
               value="8"
               data-component="body" hidden>
    <br>

        </p>
                <p>
            <b><code>bank_id</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
                <input type="number"
               name="bank_id"
               data-endpoint="PUTapi-estates--id-"
               value="8"
               data-component="body" hidden>
    <br>

        </p>
                <p>
            <b><code>email</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
                <input type="text"
               name="email"
               data-endpoint="PUTapi-estates--id-"
               value="lrbzdiukvjuvkinggksyyfrlncgxpqdtavrnfnielszxqlkefujshuzyqwrfbmuslqxckgndrsltfgwf"
               data-component="body" hidden>
    <br>
<p>Must not be greater than 100 characters.</p>
        </p>
                <p>
            <b><code>phone</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
                <input type="text"
               name="phone"
               data-endpoint="PUTapi-estates--id-"
               value="amoipcwhe"
               data-component="body" hidden>
    <br>
<p>Must not be greater than 17 characters.</p>
        </p>
                <p>
            <b><code>address</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
                <input type="text"
               name="address"
               data-endpoint="PUTapi-estates--id-"
               value="mxvdvgjvuoaajszdvgddwsmrwqfguuyaklhhqsmxsxmnmjxebfsvexityhhpkwfjuqkqsxehrkrhlupgxrhrvthewwinflsaokzqcnnfsjpqvadvwwvvexxpthtwscrdngguyxawygfxmkpoerjwtepvizwkjbxfpbbjwemarhgrk"
               data-component="body" hidden>
    <br>
<p>Must not be greater than 255 characters.</p>
        </p>
                <p>
            <b><code>accountNumber</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
                <input type="text"
               name="accountNumber"
               data-endpoint="PUTapi-estates--id-"
               value="l"
               data-component="body" hidden>
    <br>
<p>Must not be greater than 12 characters.</p>
        </p>
                <p>
            <b><code>accountName</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
                <input type="text"
               name="accountName"
               data-endpoint="PUTapi-estates--id-"
               value="xtfi"
               data-component="body" hidden>
    <br>
<p>Must not be greater than 100 characters.</p>
        </p>
                <p>
            <b><code>imageName</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
                <input type="text"
               name="imageName"
               data-endpoint="PUTapi-estates--id-"
               value=""
               data-component="body" hidden>
    <br>

        </p>
                <p>
            <b><code>accountVerified</code></b>&nbsp;&nbsp;<small>boolean</small>  &nbsp;
                <label data-endpoint="PUTapi-estates--id-" hidden>
            <input type="radio" name="accountVerified"
                   value="true"
                   data-endpoint="PUTapi-estates--id-"
                   data-component="body"
            >
            <code>true</code>
        </label>
        <label data-endpoint="PUTapi-estates--id-" hidden>
            <input type="radio" name="accountVerified"
                   value="false"
                   data-endpoint="PUTapi-estates--id-"
                   data-component="body"
            >
            <code>false</code>
        </label>
    <br>

        </p>
                <p>
            <b><code>alternateEmail</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
                <input type="text"
               name="alternateEmail"
               data-endpoint="PUTapi-estates--id-"
               value="twmqpvoojclbepkvfhydlkobgsbtzr"
               data-component="body" hidden>
    <br>
<p>Must not be greater than 100 characters.</p>
        </p>
                <p>
            <b><code>alternatePhone</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
                <input type="text"
               name="alternatePhone"
               data-endpoint="PUTapi-estates--id-"
               value="wkndfdapx"
               data-component="body" hidden>
    <br>
<p>Must not be greater than 17 characters.</p>
        </p>
                <p>
            <b><code>created_by</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
                <input type="number"
               name="created_by"
               data-endpoint="PUTapi-estates--id-"
               value="17"
               data-component="body" hidden>
    <br>

        </p>
                <p>
            <b><code>name</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
                <input type="text"
               name="name"
               data-endpoint="PUTapi-estates--id-"
               value="xrsxftawekcwcrftlkedjrpfmuhmufwyyyhuunaxghoamhh"
               data-component="body" hidden>
    <br>
<p>Must not be greater than 100 characters.</p>
        </p>
        </form>

            <h2 id="endpoints-DELETEapi-estates--id-">Remove the specified Estate from storage.</h2>

<p>
</p>

<p>DELETE /estates/{id}</p>

<span id="example-requests-DELETEapi-estates--id-">
<blockquote>Example request:</blockquote>


<pre><code class="language-bash">curl --request DELETE \
    "http://smartestateserver.test/api/estates/4" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre>

<pre><code class="language-javascript">const url = new URL(
    "http://smartestateserver.test/api/estates/4"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers,
}).then(response =&gt; response.json());</code></pre>
</span>

<span id="example-responses-DELETEapi-estates--id-">
</span>
<span id="execution-results-DELETEapi-estates--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-DELETEapi-estates--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-estates--id-"></code></pre>
</span>
<span id="execution-error-DELETEapi-estates--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-estates--id-"></code></pre>
</span>
<form id="form-DELETEapi-estates--id-" data-method="DELETE"
      data-path="api/estates/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('DELETEapi-estates--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-DELETEapi-estates--id-"
                    onclick="tryItOut('DELETEapi-estates--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-DELETEapi-estates--id-"
                    onclick="cancelTryOut('DELETEapi-estates--id-');" hidden>Cancel
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-DELETEapi-estates--id-" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-red">DELETE</small>
            <b><code>api/estates/{id}</code></b>
        </p>
                    <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <p>
                <b><code>id</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
                <input type="number"
               name="id"
               data-endpoint="DELETEapi-estates--id-"
               value="4"
               data-component="url" hidden>
    <br>
<p>The ID of the estate.</p>
            </p>
                    </form>

            <h2 id="endpoints-GETapi-states">Display a listing of the State.</h2>

<p>
</p>

<p>GET|HEAD /states</p>

<span id="example-requests-GETapi-states">
<blockquote>Example request:</blockquote>


<pre><code class="language-bash">curl --request GET \
    --get "http://smartestateserver.test/api/states" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre>

<pre><code class="language-javascript">const url = new URL(
    "http://smartestateserver.test/api/states"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
</span>

<span id="example-responses-GETapi-states">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary>
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 53
access-control-allow-origin: *
 </code></pre>
        </details>         <pre>

<code class="language-json">{
    &quot;status&quot;: &quot;Authorization Token not found&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-states" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-states"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-states"></code></pre>
</span>
<span id="execution-error-GETapi-states" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-states"></code></pre>
</span>
<form id="form-GETapi-states" data-method="GET"
      data-path="api/states"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-states', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-states"
                    onclick="tryItOut('GETapi-states');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-states"
                    onclick="cancelTryOut('GETapi-states');" hidden>Cancel
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-states" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/states</code></b>
        </p>
                    </form>

            <h2 id="endpoints-POSTapi-states">Store a newly created State in storage.</h2>

<p>
</p>

<p>POST /states</p>

<span id="example-requests-POSTapi-states">
<blockquote>Example request:</blockquote>


<pre><code class="language-bash">curl --request POST \
    "http://smartestateserver.test/api/states" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"name\": \"chxphfhdxbrumnivxqnfwpcmwximeuofcbuzu\"
}"
</code></pre>

<pre><code class="language-javascript">const url = new URL(
    "http://smartestateserver.test/api/states"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "chxphfhdxbrumnivxqnfwpcmwximeuofcbuzu"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre>
</span>

<span id="example-responses-POSTapi-states">
</span>
<span id="execution-results-POSTapi-states" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-states"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-states"></code></pre>
</span>
<span id="execution-error-POSTapi-states" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-states"></code></pre>
</span>
<form id="form-POSTapi-states" data-method="POST"
      data-path="api/states"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-states', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-states"
                    onclick="tryItOut('POSTapi-states');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-states"
                    onclick="cancelTryOut('POSTapi-states');" hidden>Cancel
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-states" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/states</code></b>
        </p>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <p>
            <b><code>name</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
                <input type="text"
               name="name"
               data-endpoint="POSTapi-states"
               value="chxphfhdxbrumnivxqnfwpcmwximeuofcbuzu"
               data-component="body" hidden>
    <br>
<p>Must not be greater than 100 characters.</p>
        </p>
                <p>
            <b><code>created_at</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
                <input type="text"
               name="created_at"
               data-endpoint="POSTapi-states"
               value=""
               data-component="body" hidden>
    <br>

        </p>
                <p>
            <b><code>updated_at</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
                <input type="text"
               name="updated_at"
               data-endpoint="POSTapi-states"
               value=""
               data-component="body" hidden>
    <br>

        </p>
                <p>
            <b><code>deleted_at</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
                <input type="text"
               name="deleted_at"
               data-endpoint="POSTapi-states"
               value=""
               data-component="body" hidden>
    <br>

        </p>
        </form>

            <h2 id="endpoints-GETapi-states--id-">Display the specified State.</h2>

<p>
</p>

<p>GET|HEAD /states/{id}</p>

<span id="example-requests-GETapi-states--id-">
<blockquote>Example request:</blockquote>


<pre><code class="language-bash">curl --request GET \
    --get "http://smartestateserver.test/api/states/4" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre>

<pre><code class="language-javascript">const url = new URL(
    "http://smartestateserver.test/api/states/4"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
</span>

<span id="example-responses-GETapi-states--id-">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary>
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 52
access-control-allow-origin: *
 </code></pre>
        </details>         <pre>

<code class="language-json">{
    &quot;status&quot;: &quot;Authorization Token not found&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-states--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-states--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-states--id-"></code></pre>
</span>
<span id="execution-error-GETapi-states--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-states--id-"></code></pre>
</span>
<form id="form-GETapi-states--id-" data-method="GET"
      data-path="api/states/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-states--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-states--id-"
                    onclick="tryItOut('GETapi-states--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-states--id-"
                    onclick="cancelTryOut('GETapi-states--id-');" hidden>Cancel
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-states--id-" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/states/{id}</code></b>
        </p>
                    <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <p>
                <b><code>id</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
                <input type="number"
               name="id"
               data-endpoint="GETapi-states--id-"
               value="4"
               data-component="url" hidden>
    <br>
<p>The ID of the state.</p>
            </p>
                    </form>

            <h2 id="endpoints-PUTapi-states--id-">Update the specified State in storage.</h2>

<p>
</p>

<p>PUT/PATCH /states/{id}</p>

<span id="example-requests-PUTapi-states--id-">
<blockquote>Example request:</blockquote>


<pre><code class="language-bash">curl --request PUT \
    "http://smartestateserver.test/api/states/4" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"name\": \"qtyvijzxksmtskyqmhhwekaoxxyehdthuvsvthhiwtuvgcnvms\"
}"
</code></pre>

<pre><code class="language-javascript">const url = new URL(
    "http://smartestateserver.test/api/states/4"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "qtyvijzxksmtskyqmhhwekaoxxyehdthuvsvthhiwtuvgcnvms"
};

fetch(url, {
    method: "PUT",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre>
</span>

<span id="example-responses-PUTapi-states--id-">
</span>
<span id="execution-results-PUTapi-states--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-PUTapi-states--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-states--id-"></code></pre>
</span>
<span id="execution-error-PUTapi-states--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-states--id-"></code></pre>
</span>
<form id="form-PUTapi-states--id-" data-method="PUT"
      data-path="api/states/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('PUTapi-states--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-PUTapi-states--id-"
                    onclick="tryItOut('PUTapi-states--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-PUTapi-states--id-"
                    onclick="cancelTryOut('PUTapi-states--id-');" hidden>Cancel
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-PUTapi-states--id-" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-darkblue">PUT</small>
            <b><code>api/states/{id}</code></b>
        </p>
            <p>
            <small class="badge badge-purple">PATCH</small>
            <b><code>api/states/{id}</code></b>
        </p>
                    <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <p>
                <b><code>id</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
                <input type="number"
               name="id"
               data-endpoint="PUTapi-states--id-"
               value="4"
               data-component="url" hidden>
    <br>
<p>The ID of the state.</p>
            </p>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <p>
            <b><code>name</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
                <input type="text"
               name="name"
               data-endpoint="PUTapi-states--id-"
               value="qtyvijzxksmtskyqmhhwekaoxxyehdthuvsvthhiwtuvgcnvms"
               data-component="body" hidden>
    <br>
<p>Must not be greater than 100 characters.</p>
        </p>
                <p>
            <b><code>created_at</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
                <input type="text"
               name="created_at"
               data-endpoint="PUTapi-states--id-"
               value=""
               data-component="body" hidden>
    <br>

        </p>
                <p>
            <b><code>updated_at</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
                <input type="text"
               name="updated_at"
               data-endpoint="PUTapi-states--id-"
               value=""
               data-component="body" hidden>
    <br>

        </p>
                <p>
            <b><code>deleted_at</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
                <input type="text"
               name="deleted_at"
               data-endpoint="PUTapi-states--id-"
               value=""
               data-component="body" hidden>
    <br>

        </p>
        </form>

            <h2 id="endpoints-DELETEapi-states--id-">Remove the specified State from storage.</h2>

<p>
</p>

<p>DELETE /states/{id}</p>

<span id="example-requests-DELETEapi-states--id-">
<blockquote>Example request:</blockquote>


<pre><code class="language-bash">curl --request DELETE \
    "http://smartestateserver.test/api/states/6" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre>

<pre><code class="language-javascript">const url = new URL(
    "http://smartestateserver.test/api/states/6"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers,
}).then(response =&gt; response.json());</code></pre>
</span>

<span id="example-responses-DELETEapi-states--id-">
</span>
<span id="execution-results-DELETEapi-states--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-DELETEapi-states--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-states--id-"></code></pre>
</span>
<span id="execution-error-DELETEapi-states--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-states--id-"></code></pre>
</span>
<form id="form-DELETEapi-states--id-" data-method="DELETE"
      data-path="api/states/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('DELETEapi-states--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-DELETEapi-states--id-"
                    onclick="tryItOut('DELETEapi-states--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-DELETEapi-states--id-"
                    onclick="cancelTryOut('DELETEapi-states--id-');" hidden>Cancel
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-DELETEapi-states--id-" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-red">DELETE</small>
            <b><code>api/states/{id}</code></b>
        </p>
                    <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <p>
                <b><code>id</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
                <input type="number"
               name="id"
               data-endpoint="DELETEapi-states--id-"
               value="6"
               data-component="url" hidden>
    <br>
<p>The ID of the state.</p>
            </p>
                    </form>

            <h2 id="endpoints-GETapi-cities">GET api/cities</h2>

<p>
</p>



<span id="example-requests-GETapi-cities">
<blockquote>Example request:</blockquote>


<pre><code class="language-bash">curl --request GET \
    --get "http://smartestateserver.test/api/cities" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre>

<pre><code class="language-javascript">const url = new URL(
    "http://smartestateserver.test/api/cities"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
</span>

<span id="example-responses-GETapi-cities">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary>
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 51
access-control-allow-origin: *
 </code></pre>
        </details>         <pre>

<code class="language-json">{
    &quot;status&quot;: &quot;Authorization Token not found&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-cities" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-cities"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-cities"></code></pre>
</span>
<span id="execution-error-GETapi-cities" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-cities"></code></pre>
</span>
<form id="form-GETapi-cities" data-method="GET"
      data-path="api/cities"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-cities', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-cities"
                    onclick="tryItOut('GETapi-cities');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-cities"
                    onclick="cancelTryOut('GETapi-cities');" hidden>Cancel
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-cities" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/cities</code></b>
        </p>
                    </form>

            <h2 id="endpoints-POSTapi-cities">POST api/cities</h2>

<p>
</p>



<span id="example-requests-POSTapi-cities">
<blockquote>Example request:</blockquote>


<pre><code class="language-bash">curl --request POST \
    "http://smartestateserver.test/api/cities" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"state_id\": \"eos\",
    \"name\": \"hvsxcu\"
}"
</code></pre>

<pre><code class="language-javascript">const url = new URL(
    "http://smartestateserver.test/api/cities"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "state_id": "eos",
    "name": "hvsxcu"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre>
</span>

<span id="example-responses-POSTapi-cities">
</span>
<span id="execution-results-POSTapi-cities" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-cities"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-cities"></code></pre>
</span>
<span id="execution-error-POSTapi-cities" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-cities"></code></pre>
</span>
<form id="form-POSTapi-cities" data-method="POST"
      data-path="api/cities"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-cities', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-cities"
                    onclick="tryItOut('POSTapi-cities');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-cities"
                    onclick="cancelTryOut('POSTapi-cities');" hidden>Cancel
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-cities" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/cities</code></b>
        </p>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <p>
            <b><code>state_id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
                <input type="text"
               name="state_id"
               data-endpoint="POSTapi-cities"
               value="eos"
               data-component="body" hidden>
    <br>

        </p>
                <p>
            <b><code>name</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
                <input type="text"
               name="name"
               data-endpoint="POSTapi-cities"
               value="hvsxcu"
               data-component="body" hidden>
    <br>
<p>Must not be greater than 255 characters.</p>
        </p>
                <p>
            <b><code>created_at</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
                <input type="text"
               name="created_at"
               data-endpoint="POSTapi-cities"
               value=""
               data-component="body" hidden>
    <br>

        </p>
                <p>
            <b><code>updated_at</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
                <input type="text"
               name="updated_at"
               data-endpoint="POSTapi-cities"
               value=""
               data-component="body" hidden>
    <br>

        </p>
                <p>
            <b><code>deleted_at</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
                <input type="text"
               name="deleted_at"
               data-endpoint="POSTapi-cities"
               value=""
               data-component="body" hidden>
    <br>

        </p>
        </form>

            <h2 id="endpoints-GETapi-cities--id-">GET api/cities/{id}</h2>

<p>
</p>



<span id="example-requests-GETapi-cities--id-">
<blockquote>Example request:</blockquote>


<pre><code class="language-bash">curl --request GET \
    --get "http://smartestateserver.test/api/cities/17" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre>

<pre><code class="language-javascript">const url = new URL(
    "http://smartestateserver.test/api/cities/17"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
</span>

<span id="example-responses-GETapi-cities--id-">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary>
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 50
access-control-allow-origin: *
 </code></pre>
        </details>         <pre>

<code class="language-json">{
    &quot;status&quot;: &quot;Authorization Token not found&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-cities--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-cities--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-cities--id-"></code></pre>
</span>
<span id="execution-error-GETapi-cities--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-cities--id-"></code></pre>
</span>
<form id="form-GETapi-cities--id-" data-method="GET"
      data-path="api/cities/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-cities--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-cities--id-"
                    onclick="tryItOut('GETapi-cities--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-cities--id-"
                    onclick="cancelTryOut('GETapi-cities--id-');" hidden>Cancel
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-cities--id-" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/cities/{id}</code></b>
        </p>
                    <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <p>
                <b><code>id</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
                <input type="number"
               name="id"
               data-endpoint="GETapi-cities--id-"
               value="17"
               data-component="url" hidden>
    <br>
<p>The ID of the city.</p>
            </p>
                    </form>

            <h2 id="endpoints-PUTapi-cities--id-">PUT api/cities/{id}</h2>

<p>
</p>



<span id="example-requests-PUTapi-cities--id-">
<blockquote>Example request:</blockquote>


<pre><code class="language-bash">curl --request PUT \
    "http://smartestateserver.test/api/cities/13" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"state_id\": \"distinctio\",
    \"name\": \"sjiqqvflnkniyncqztxjhhowhdzcevemvxxdsemxwwiudqhwvzehdruyefwyeyuhzviporygleltxtmoqsgrivkllgxxrzatvcrqzltkcyhcmymstfycugelbyfpzloukzhvekvxwllhofrhjhwcvgxoyvwfouvccyfixsm\"
}"
</code></pre>

<pre><code class="language-javascript">const url = new URL(
    "http://smartestateserver.test/api/cities/13"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "state_id": "distinctio",
    "name": "sjiqqvflnkniyncqztxjhhowhdzcevemvxxdsemxwwiudqhwvzehdruyefwyeyuhzviporygleltxtmoqsgrivkllgxxrzatvcrqzltkcyhcmymstfycugelbyfpzloukzhvekvxwllhofrhjhwcvgxoyvwfouvccyfixsm"
};

fetch(url, {
    method: "PUT",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre>
</span>

<span id="example-responses-PUTapi-cities--id-">
</span>
<span id="execution-results-PUTapi-cities--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-PUTapi-cities--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-cities--id-"></code></pre>
</span>
<span id="execution-error-PUTapi-cities--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-cities--id-"></code></pre>
</span>
<form id="form-PUTapi-cities--id-" data-method="PUT"
      data-path="api/cities/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('PUTapi-cities--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-PUTapi-cities--id-"
                    onclick="tryItOut('PUTapi-cities--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-PUTapi-cities--id-"
                    onclick="cancelTryOut('PUTapi-cities--id-');" hidden>Cancel
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-PUTapi-cities--id-" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-darkblue">PUT</small>
            <b><code>api/cities/{id}</code></b>
        </p>
            <p>
            <small class="badge badge-purple">PATCH</small>
            <b><code>api/cities/{id}</code></b>
        </p>
                    <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <p>
                <b><code>id</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
                <input type="number"
               name="id"
               data-endpoint="PUTapi-cities--id-"
               value="13"
               data-component="url" hidden>
    <br>
<p>The ID of the city.</p>
            </p>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <p>
            <b><code>state_id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
                <input type="text"
               name="state_id"
               data-endpoint="PUTapi-cities--id-"
               value="distinctio"
               data-component="body" hidden>
    <br>

        </p>
                <p>
            <b><code>name</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
                <input type="text"
               name="name"
               data-endpoint="PUTapi-cities--id-"
               value="sjiqqvflnkniyncqztxjhhowhdzcevemvxxdsemxwwiudqhwvzehdruyefwyeyuhzviporygleltxtmoqsgrivkllgxxrzatvcrqzltkcyhcmymstfycugelbyfpzloukzhvekvxwllhofrhjhwcvgxoyvwfouvccyfixsm"
               data-component="body" hidden>
    <br>
<p>Must not be greater than 255 characters.</p>
        </p>
                <p>
            <b><code>created_at</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
                <input type="text"
               name="created_at"
               data-endpoint="PUTapi-cities--id-"
               value=""
               data-component="body" hidden>
    <br>

        </p>
                <p>
            <b><code>updated_at</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
                <input type="text"
               name="updated_at"
               data-endpoint="PUTapi-cities--id-"
               value=""
               data-component="body" hidden>
    <br>

        </p>
                <p>
            <b><code>deleted_at</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
                <input type="text"
               name="deleted_at"
               data-endpoint="PUTapi-cities--id-"
               value=""
               data-component="body" hidden>
    <br>

        </p>
        </form>

            <h2 id="endpoints-DELETEapi-cities--id-">DELETE api/cities/{id}</h2>

<p>
</p>



<span id="example-requests-DELETEapi-cities--id-">
<blockquote>Example request:</blockquote>


<pre><code class="language-bash">curl --request DELETE \
    "http://smartestateserver.test/api/cities/10" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre>

<pre><code class="language-javascript">const url = new URL(
    "http://smartestateserver.test/api/cities/10"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers,
}).then(response =&gt; response.json());</code></pre>
</span>

<span id="example-responses-DELETEapi-cities--id-">
</span>
<span id="execution-results-DELETEapi-cities--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-DELETEapi-cities--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-cities--id-"></code></pre>
</span>
<span id="execution-error-DELETEapi-cities--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-cities--id-"></code></pre>
</span>
<form id="form-DELETEapi-cities--id-" data-method="DELETE"
      data-path="api/cities/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('DELETEapi-cities--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-DELETEapi-cities--id-"
                    onclick="tryItOut('DELETEapi-cities--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-DELETEapi-cities--id-"
                    onclick="cancelTryOut('DELETEapi-cities--id-');" hidden>Cancel
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-DELETEapi-cities--id-" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-red">DELETE</small>
            <b><code>api/cities/{id}</code></b>
        </p>
                    <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <p>
                <b><code>id</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
                <input type="number"
               name="id"
               data-endpoint="DELETEapi-cities--id-"
               value="10"
               data-component="url" hidden>
    <br>
<p>The ID of the city.</p>
            </p>
                    </form>

            <h2 id="endpoints-GETapi-banks">GET api/banks</h2>

<p>
</p>



<span id="example-requests-GETapi-banks">
<blockquote>Example request:</blockquote>


<pre><code class="language-bash">curl --request GET \
    --get "http://smartestateserver.test/api/banks" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre>

<pre><code class="language-javascript">const url = new URL(
    "http://smartestateserver.test/api/banks"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
</span>

<span id="example-responses-GETapi-banks">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary>
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 49
access-control-allow-origin: *
 </code></pre>
        </details>         <pre>

<code class="language-json">{
    &quot;status&quot;: &quot;Authorization Token not found&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-banks" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-banks"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-banks"></code></pre>
</span>
<span id="execution-error-GETapi-banks" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-banks"></code></pre>
</span>
<form id="form-GETapi-banks" data-method="GET"
      data-path="api/banks"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-banks', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-banks"
                    onclick="tryItOut('GETapi-banks');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-banks"
                    onclick="cancelTryOut('GETapi-banks');" hidden>Cancel
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-banks" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/banks</code></b>
        </p>
                    </form>

            <h2 id="endpoints-POSTapi-banks">POST api/banks</h2>

<p>
</p>



<span id="example-requests-POSTapi-banks">
<blockquote>Example request:</blockquote>


<pre><code class="language-bash">curl --request POST \
    "http://smartestateserver.test/api/banks" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"name\": \"nysefgvkmzjezmfydssrniuaiqpsujjcobkgdxgvzehiyysgqakfgidtuvrdtwawxdvbhkgjdcayoemmmpbewnosje\",
    \"bank_code\": \"\",
    \"sort_code\": \"onnbluafi\"
}"
</code></pre>

<pre><code class="language-javascript">const url = new URL(
    "http://smartestateserver.test/api/banks"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "nysefgvkmzjezmfydssrniuaiqpsujjcobkgdxgvzehiyysgqakfgidtuvrdtwawxdvbhkgjdcayoemmmpbewnosje",
    "bank_code": "",
    "sort_code": "onnbluafi"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre>
</span>

<span id="example-responses-POSTapi-banks">
</span>
<span id="execution-results-POSTapi-banks" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-banks"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-banks"></code></pre>
</span>
<span id="execution-error-POSTapi-banks" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-banks"></code></pre>
</span>
<form id="form-POSTapi-banks" data-method="POST"
      data-path="api/banks"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-banks', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-banks"
                    onclick="tryItOut('POSTapi-banks');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-banks"
                    onclick="cancelTryOut('POSTapi-banks');" hidden>Cancel
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-banks" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/banks</code></b>
        </p>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <p>
            <b><code>name</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
                <input type="text"
               name="name"
               data-endpoint="POSTapi-banks"
               value="nysefgvkmzjezmfydssrniuaiqpsujjcobkgdxgvzehiyysgqakfgidtuvrdtwawxdvbhkgjdcayoemmmpbewnosje"
               data-component="body" hidden>
    <br>
<p>Must not be greater than 191 characters.</p>
        </p>
                <p>
            <b><code>bank_code</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
                <input type="text"
               name="bank_code"
               data-endpoint="POSTapi-banks"
               value=""
               data-component="body" hidden>
    <br>
<p>Must not be greater than 5 characters.</p>
        </p>
                <p>
            <b><code>sort_code</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
                <input type="text"
               name="sort_code"
               data-endpoint="POSTapi-banks"
               value="onnbluafi"
               data-component="body" hidden>
    <br>
<p>Must not be greater than 10 characters.</p>
        </p>
                <p>
            <b><code>created_at</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
                <input type="text"
               name="created_at"
               data-endpoint="POSTapi-banks"
               value=""
               data-component="body" hidden>
    <br>

        </p>
                <p>
            <b><code>updated_at</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
                <input type="text"
               name="updated_at"
               data-endpoint="POSTapi-banks"
               value=""
               data-component="body" hidden>
    <br>

        </p>
                <p>
            <b><code>deleted_at</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
                <input type="text"
               name="deleted_at"
               data-endpoint="POSTapi-banks"
               value=""
               data-component="body" hidden>
    <br>

        </p>
        </form>

            <h2 id="endpoints-GETapi-banks--id-">GET api/banks/{id}</h2>

<p>
</p>



<span id="example-requests-GETapi-banks--id-">
<blockquote>Example request:</blockquote>


<pre><code class="language-bash">curl --request GET \
    --get "http://smartestateserver.test/api/banks/1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre>

<pre><code class="language-javascript">const url = new URL(
    "http://smartestateserver.test/api/banks/1"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
</span>

<span id="example-responses-GETapi-banks--id-">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary>
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 48
access-control-allow-origin: *
 </code></pre>
        </details>         <pre>

<code class="language-json">{
    &quot;status&quot;: &quot;Authorization Token not found&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-banks--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-banks--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-banks--id-"></code></pre>
</span>
<span id="execution-error-GETapi-banks--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-banks--id-"></code></pre>
</span>
<form id="form-GETapi-banks--id-" data-method="GET"
      data-path="api/banks/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-banks--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-banks--id-"
                    onclick="tryItOut('GETapi-banks--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-banks--id-"
                    onclick="cancelTryOut('GETapi-banks--id-');" hidden>Cancel
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-banks--id-" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/banks/{id}</code></b>
        </p>
                    <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <p>
                <b><code>id</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
                <input type="number"
               name="id"
               data-endpoint="GETapi-banks--id-"
               value="1"
               data-component="url" hidden>
    <br>
<p>The ID of the bank.</p>
            </p>
                    </form>

            <h2 id="endpoints-PUTapi-banks--id-">PUT api/banks/{id}</h2>

<p>
</p>



<span id="example-requests-PUTapi-banks--id-">
<blockquote>Example request:</blockquote>


<pre><code class="language-bash">curl --request PUT \
    "http://smartestateserver.test/api/banks/10" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"name\": \"msrqurhhzhfkmvvhgjrllkjcclepwoibstvlwabbhamtwv\",
    \"bank_code\": \"fqmn\",
    \"sort_code\": \"fpypagqok\"
}"
</code></pre>

<pre><code class="language-javascript">const url = new URL(
    "http://smartestateserver.test/api/banks/10"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "msrqurhhzhfkmvvhgjrllkjcclepwoibstvlwabbhamtwv",
    "bank_code": "fqmn",
    "sort_code": "fpypagqok"
};

fetch(url, {
    method: "PUT",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre>
</span>

<span id="example-responses-PUTapi-banks--id-">
</span>
<span id="execution-results-PUTapi-banks--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-PUTapi-banks--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-banks--id-"></code></pre>
</span>
<span id="execution-error-PUTapi-banks--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-banks--id-"></code></pre>
</span>
<form id="form-PUTapi-banks--id-" data-method="PUT"
      data-path="api/banks/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('PUTapi-banks--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-PUTapi-banks--id-"
                    onclick="tryItOut('PUTapi-banks--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-PUTapi-banks--id-"
                    onclick="cancelTryOut('PUTapi-banks--id-');" hidden>Cancel
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-PUTapi-banks--id-" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-darkblue">PUT</small>
            <b><code>api/banks/{id}</code></b>
        </p>
            <p>
            <small class="badge badge-purple">PATCH</small>
            <b><code>api/banks/{id}</code></b>
        </p>
                    <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <p>
                <b><code>id</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
                <input type="number"
               name="id"
               data-endpoint="PUTapi-banks--id-"
               value="10"
               data-component="url" hidden>
    <br>
<p>The ID of the bank.</p>
            </p>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <p>
            <b><code>name</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
                <input type="text"
               name="name"
               data-endpoint="PUTapi-banks--id-"
               value="msrqurhhzhfkmvvhgjrllkjcclepwoibstvlwabbhamtwv"
               data-component="body" hidden>
    <br>
<p>Must not be greater than 191 characters.</p>
        </p>
                <p>
            <b><code>bank_code</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
                <input type="text"
               name="bank_code"
               data-endpoint="PUTapi-banks--id-"
               value="fqmn"
               data-component="body" hidden>
    <br>
<p>Must not be greater than 5 characters.</p>
        </p>
                <p>
            <b><code>sort_code</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
                <input type="text"
               name="sort_code"
               data-endpoint="PUTapi-banks--id-"
               value="fpypagqok"
               data-component="body" hidden>
    <br>
<p>Must not be greater than 10 characters.</p>
        </p>
                <p>
            <b><code>created_at</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
                <input type="text"
               name="created_at"
               data-endpoint="PUTapi-banks--id-"
               value=""
               data-component="body" hidden>
    <br>

        </p>
                <p>
            <b><code>updated_at</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
                <input type="text"
               name="updated_at"
               data-endpoint="PUTapi-banks--id-"
               value=""
               data-component="body" hidden>
    <br>

        </p>
                <p>
            <b><code>deleted_at</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
                <input type="text"
               name="deleted_at"
               data-endpoint="PUTapi-banks--id-"
               value=""
               data-component="body" hidden>
    <br>

        </p>
        </form>

            <h2 id="endpoints-DELETEapi-banks--id-">DELETE api/banks/{id}</h2>

<p>
</p>



<span id="example-requests-DELETEapi-banks--id-">
<blockquote>Example request:</blockquote>


<pre><code class="language-bash">curl --request DELETE \
    "http://smartestateserver.test/api/banks/8" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre>

<pre><code class="language-javascript">const url = new URL(
    "http://smartestateserver.test/api/banks/8"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers,
}).then(response =&gt; response.json());</code></pre>
</span>

<span id="example-responses-DELETEapi-banks--id-">
</span>
<span id="execution-results-DELETEapi-banks--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-DELETEapi-banks--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-banks--id-"></code></pre>
</span>
<span id="execution-error-DELETEapi-banks--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-banks--id-"></code></pre>
</span>
<form id="form-DELETEapi-banks--id-" data-method="DELETE"
      data-path="api/banks/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('DELETEapi-banks--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-DELETEapi-banks--id-"
                    onclick="tryItOut('DELETEapi-banks--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-DELETEapi-banks--id-"
                    onclick="cancelTryOut('DELETEapi-banks--id-');" hidden>Cancel
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-DELETEapi-banks--id-" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-red">DELETE</small>
            <b><code>api/banks/{id}</code></b>
        </p>
                    <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <p>
                <b><code>id</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
                <input type="number"
               name="id"
               data-endpoint="DELETEapi-banks--id-"
               value="8"
               data-component="url" hidden>
    <br>
<p>The ID of the bank.</p>
            </p>
                    </form>

            <h2 id="endpoints-GETapi-roles">Display a listing of the Role.</h2>

<p>
</p>

<p>GET|HEAD /roles</p>

<span id="example-requests-GETapi-roles">
<blockquote>Example request:</blockquote>


<pre><code class="language-bash">curl --request GET \
    --get "http://smartestateserver.test/api/roles" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre>

<pre><code class="language-javascript">const url = new URL(
    "http://smartestateserver.test/api/roles"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
</span>

<span id="example-responses-GETapi-roles">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary>
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 47
access-control-allow-origin: *
 </code></pre>
        </details>         <pre>

<code class="language-json">{
    &quot;status&quot;: &quot;Authorization Token not found&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-roles" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-roles"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-roles"></code></pre>
</span>
<span id="execution-error-GETapi-roles" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-roles"></code></pre>
</span>
<form id="form-GETapi-roles" data-method="GET"
      data-path="api/roles"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-roles', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-roles"
                    onclick="tryItOut('GETapi-roles');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-roles"
                    onclick="cancelTryOut('GETapi-roles');" hidden>Cancel
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-roles" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/roles</code></b>
        </p>
                    </form>

            <h2 id="endpoints-POSTapi-roles">Store a newly created Role in storage.</h2>

<p>
</p>

<p>POST /roles</p>

<span id="example-requests-POSTapi-roles">
<blockquote>Example request:</blockquote>


<pre><code class="language-bash">curl --request POST \
    "http://smartestateserver.test/api/roles" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"name\": \"ehqasdjttbpkwkhgswqmcvzrxhznejpqwemkjcxvmnqemyw\",
    \"guard_name\": \"yuqkmfxvrqiuhbhrozegucwleknme\"
}"
</code></pre>

<pre><code class="language-javascript">const url = new URL(
    "http://smartestateserver.test/api/roles"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "ehqasdjttbpkwkhgswqmcvzrxhznejpqwemkjcxvmnqemyw",
    "guard_name": "yuqkmfxvrqiuhbhrozegucwleknme"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre>
</span>

<span id="example-responses-POSTapi-roles">
</span>
<span id="execution-results-POSTapi-roles" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-roles"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-roles"></code></pre>
</span>
<span id="execution-error-POSTapi-roles" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-roles"></code></pre>
</span>
<form id="form-POSTapi-roles" data-method="POST"
      data-path="api/roles"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-roles', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-roles"
                    onclick="tryItOut('POSTapi-roles');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-roles"
                    onclick="cancelTryOut('POSTapi-roles');" hidden>Cancel
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-roles" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/roles</code></b>
        </p>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <p>
            <b><code>name</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
                <input type="text"
               name="name"
               data-endpoint="POSTapi-roles"
               value="ehqasdjttbpkwkhgswqmcvzrxhznejpqwemkjcxvmnqemyw"
               data-component="body" hidden>
    <br>
<p>Must not be greater than 255 characters.</p>
        </p>
                <p>
            <b><code>guard_name</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
                <input type="text"
               name="guard_name"
               data-endpoint="POSTapi-roles"
               value="yuqkmfxvrqiuhbhrozegucwleknme"
               data-component="body" hidden>
    <br>
<p>Must not be greater than 255 characters.</p>
        </p>
                <p>
            <b><code>created_at</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
                <input type="text"
               name="created_at"
               data-endpoint="POSTapi-roles"
               value=""
               data-component="body" hidden>
    <br>

        </p>
                <p>
            <b><code>updated_at</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
                <input type="text"
               name="updated_at"
               data-endpoint="POSTapi-roles"
               value=""
               data-component="body" hidden>
    <br>

        </p>
        </form>

            <h2 id="endpoints-GETapi-roles--id-">Display the specified Role.</h2>

<p>
</p>

<p>GET|HEAD /roles/{id}</p>

<span id="example-requests-GETapi-roles--id-">
<blockquote>Example request:</blockquote>


<pre><code class="language-bash">curl --request GET \
    --get "http://smartestateserver.test/api/roles/16" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre>

<pre><code class="language-javascript">const url = new URL(
    "http://smartestateserver.test/api/roles/16"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
</span>

<span id="example-responses-GETapi-roles--id-">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary>
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 46
access-control-allow-origin: *
 </code></pre>
        </details>         <pre>

<code class="language-json">{
    &quot;status&quot;: &quot;Authorization Token not found&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-roles--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-roles--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-roles--id-"></code></pre>
</span>
<span id="execution-error-GETapi-roles--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-roles--id-"></code></pre>
</span>
<form id="form-GETapi-roles--id-" data-method="GET"
      data-path="api/roles/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-roles--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-roles--id-"
                    onclick="tryItOut('GETapi-roles--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-roles--id-"
                    onclick="cancelTryOut('GETapi-roles--id-');" hidden>Cancel
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-roles--id-" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/roles/{id}</code></b>
        </p>
                    <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <p>
                <b><code>id</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
                <input type="number"
               name="id"
               data-endpoint="GETapi-roles--id-"
               value="16"
               data-component="url" hidden>
    <br>
<p>The ID of the role.</p>
            </p>
                    </form>

            <h2 id="endpoints-PUTapi-roles--id-">Update the specified Role in storage.</h2>

<p>
</p>

<p>PUT/PATCH /roles/{id}</p>

<span id="example-requests-PUTapi-roles--id-">
<blockquote>Example request:</blockquote>


<pre><code class="language-bash">curl --request PUT \
    "http://smartestateserver.test/api/roles/9" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"name\": \"jdaylycwbdmtitkvgwnmwtrclstyxlnwbaosxbhfgptdfzazlhfqfvixanelrmsq\",
    \"guard_name\": \"glgcjdysmsluwkoclkojfunwqhicgymrsprcyjqyqghqtaxqhsvzjqdgnijnpnxhbdghtwhonodaysdegaldxagbgplqnbrltkdaxpzxqrpxboywnnplwwvivxfenvqspbpqcsheykwbjxrlgjoxhkmbzcgstgfxphfvkooatrysevmdaftrwuqp\"
}"
</code></pre>

<pre><code class="language-javascript">const url = new URL(
    "http://smartestateserver.test/api/roles/9"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "jdaylycwbdmtitkvgwnmwtrclstyxlnwbaosxbhfgptdfzazlhfqfvixanelrmsq",
    "guard_name": "glgcjdysmsluwkoclkojfunwqhicgymrsprcyjqyqghqtaxqhsvzjqdgnijnpnxhbdghtwhonodaysdegaldxagbgplqnbrltkdaxpzxqrpxboywnnplwwvivxfenvqspbpqcsheykwbjxrlgjoxhkmbzcgstgfxphfvkooatrysevmdaftrwuqp"
};

fetch(url, {
    method: "PUT",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre>
</span>

<span id="example-responses-PUTapi-roles--id-">
</span>
<span id="execution-results-PUTapi-roles--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-PUTapi-roles--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-roles--id-"></code></pre>
</span>
<span id="execution-error-PUTapi-roles--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-roles--id-"></code></pre>
</span>
<form id="form-PUTapi-roles--id-" data-method="PUT"
      data-path="api/roles/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('PUTapi-roles--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-PUTapi-roles--id-"
                    onclick="tryItOut('PUTapi-roles--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-PUTapi-roles--id-"
                    onclick="cancelTryOut('PUTapi-roles--id-');" hidden>Cancel
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-PUTapi-roles--id-" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-darkblue">PUT</small>
            <b><code>api/roles/{id}</code></b>
        </p>
            <p>
            <small class="badge badge-purple">PATCH</small>
            <b><code>api/roles/{id}</code></b>
        </p>
                    <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <p>
                <b><code>id</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
                <input type="number"
               name="id"
               data-endpoint="PUTapi-roles--id-"
               value="9"
               data-component="url" hidden>
    <br>
<p>The ID of the role.</p>
            </p>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <p>
            <b><code>name</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
                <input type="text"
               name="name"
               data-endpoint="PUTapi-roles--id-"
               value="jdaylycwbdmtitkvgwnmwtrclstyxlnwbaosxbhfgptdfzazlhfqfvixanelrmsq"
               data-component="body" hidden>
    <br>
<p>Must not be greater than 255 characters.</p>
        </p>
                <p>
            <b><code>guard_name</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
                <input type="text"
               name="guard_name"
               data-endpoint="PUTapi-roles--id-"
               value="glgcjdysmsluwkoclkojfunwqhicgymrsprcyjqyqghqtaxqhsvzjqdgnijnpnxhbdghtwhonodaysdegaldxagbgplqnbrltkdaxpzxqrpxboywnnplwwvivxfenvqspbpqcsheykwbjxrlgjoxhkmbzcgstgfxphfvkooatrysevmdaftrwuqp"
               data-component="body" hidden>
    <br>
<p>Must not be greater than 255 characters.</p>
        </p>
                <p>
            <b><code>created_at</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
                <input type="text"
               name="created_at"
               data-endpoint="PUTapi-roles--id-"
               value=""
               data-component="body" hidden>
    <br>

        </p>
                <p>
            <b><code>updated_at</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
                <input type="text"
               name="updated_at"
               data-endpoint="PUTapi-roles--id-"
               value=""
               data-component="body" hidden>
    <br>

        </p>
        </form>

            <h2 id="endpoints-DELETEapi-roles--id-">Remove the specified Role from storage.</h2>

<p>
</p>

<p>DELETE /roles/{id}</p>

<span id="example-requests-DELETEapi-roles--id-">
<blockquote>Example request:</blockquote>


<pre><code class="language-bash">curl --request DELETE \
    "http://smartestateserver.test/api/roles/7" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre>

<pre><code class="language-javascript">const url = new URL(
    "http://smartestateserver.test/api/roles/7"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers,
}).then(response =&gt; response.json());</code></pre>
</span>

<span id="example-responses-DELETEapi-roles--id-">
</span>
<span id="execution-results-DELETEapi-roles--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-DELETEapi-roles--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-roles--id-"></code></pre>
</span>
<span id="execution-error-DELETEapi-roles--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-roles--id-"></code></pre>
</span>
<form id="form-DELETEapi-roles--id-" data-method="DELETE"
      data-path="api/roles/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('DELETEapi-roles--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-DELETEapi-roles--id-"
                    onclick="tryItOut('DELETEapi-roles--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-DELETEapi-roles--id-"
                    onclick="cancelTryOut('DELETEapi-roles--id-');" hidden>Cancel
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-DELETEapi-roles--id-" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-red">DELETE</small>
            <b><code>api/roles/{id}</code></b>
        </p>
                    <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <p>
                <b><code>id</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
                <input type="number"
               name="id"
               data-endpoint="DELETEapi-roles--id-"
               value="7"
               data-component="url" hidden>
    <br>
<p>The ID of the role.</p>
            </p>
                    </form>

            <h2 id="endpoints-GETapi-residents">Display a listing of the Resident.</h2>

<p>
</p>

<p>GET|HEAD /residents</p>

<span id="example-requests-GETapi-residents">
<blockquote>Example request:</blockquote>


<pre><code class="language-bash">curl --request GET \
    --get "http://smartestateserver.test/api/residents" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre>

<pre><code class="language-javascript">const url = new URL(
    "http://smartestateserver.test/api/residents"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
</span>

<span id="example-responses-GETapi-residents">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary>
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 45
access-control-allow-origin: *
 </code></pre>
        </details>         <pre>

<code class="language-json">{
    &quot;status&quot;: &quot;Authorization Token not found&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-residents" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-residents"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-residents"></code></pre>
</span>
<span id="execution-error-GETapi-residents" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-residents"></code></pre>
</span>
<form id="form-GETapi-residents" data-method="GET"
      data-path="api/residents"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-residents', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-residents"
                    onclick="tryItOut('GETapi-residents');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-residents"
                    onclick="cancelTryOut('GETapi-residents');" hidden>Cancel
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-residents" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/residents</code></b>
        </p>
                    </form>

            <h2 id="endpoints-POSTapi-residents">Store a newly created Resident in storage.</h2>

<p>
</p>

<p>POST /residents</p>

<span id="example-requests-POSTapi-residents">
<blockquote>Example request:</blockquote>


<pre><code class="language-bash">curl --request POST \
    "http://smartestateserver.test/api/residents" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"surname\": \"jfrkcbnjffwokydldpareuyrcublqewfgjfafbiddodgughmldlsdphqxcmmtpdsymczibucflftcbc\",
    \"othernames\": \"ucdmhvitctfclrsw\",
    \"phone\": \"dn\",
    \"gender\": \"sed\",
    \"email\": \"pwcygavyfbxumtiolthynboxdvqrevgneethkvxabfwpdhmxqkdazooxnzzclgwyusycghzhyeumiilwilwvykcvnclrouyzsn\",
    \"remember_token\": \"aopjvxtunhglizrwgjtnbvnkojpqc\",
    \"estateCode\": \"libero\",
    \"meterNo\": \"bjzpitiqaorcohyzifyqmei\",
    \"dateMovedIn\": \"2021-11-06T00:42:13\"
}"
</code></pre>

<pre><code class="language-javascript">const url = new URL(
    "http://smartestateserver.test/api/residents"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "surname": "jfrkcbnjffwokydldpareuyrcublqewfgjfafbiddodgughmldlsdphqxcmmtpdsymczibucflftcbc",
    "othernames": "ucdmhvitctfclrsw",
    "phone": "dn",
    "gender": "sed",
    "email": "pwcygavyfbxumtiolthynboxdvqrevgneethkvxabfwpdhmxqkdazooxnzzclgwyusycghzhyeumiilwilwvykcvnclrouyzsn",
    "remember_token": "aopjvxtunhglizrwgjtnbvnkojpqc",
    "estateCode": "libero",
    "meterNo": "bjzpitiqaorcohyzifyqmei",
    "dateMovedIn": "2021-11-06T00:42:13"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre>
</span>

<span id="example-responses-POSTapi-residents">
</span>
<span id="execution-results-POSTapi-residents" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-residents"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-residents"></code></pre>
</span>
<span id="execution-error-POSTapi-residents" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-residents"></code></pre>
</span>
<form id="form-POSTapi-residents" data-method="POST"
      data-path="api/residents"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-residents', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-residents"
                    onclick="tryItOut('POSTapi-residents');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-residents"
                    onclick="cancelTryOut('POSTapi-residents');" hidden>Cancel
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-residents" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/residents</code></b>
        </p>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <p>
            <b><code>surname</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
                <input type="text"
               name="surname"
               data-endpoint="POSTapi-residents"
               value="jfrkcbnjffwokydldpareuyrcublqewfgjfafbiddodgughmldlsdphqxcmmtpdsymczibucflftcbc"
               data-component="body" hidden>
    <br>
<p>Must not be greater than 100 characters.</p>
        </p>
                <p>
            <b><code>othernames</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
                <input type="text"
               name="othernames"
               data-endpoint="POSTapi-residents"
               value="ucdmhvitctfclrsw"
               data-component="body" hidden>
    <br>
<p>Must not be greater than 100 characters.</p>
        </p>
                <p>
            <b><code>phone</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
                <input type="text"
               name="phone"
               data-endpoint="POSTapi-residents"
               value="dn"
               data-component="body" hidden>
    <br>
<p>Must not be greater than 14 characters.</p>
        </p>
                <p>
            <b><code>gender</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
                <input type="text"
               name="gender"
               data-endpoint="POSTapi-residents"
               value="sed"
               data-component="body" hidden>
    <br>

        </p>
                <p>
            <b><code>email</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
                <input type="text"
               name="email"
               data-endpoint="POSTapi-residents"
               value="pwcygavyfbxumtiolthynboxdvqrevgneethkvxabfwpdhmxqkdazooxnzzclgwyusycghzhyeumiilwilwvykcvnclrouyzsn"
               data-component="body" hidden>
    <br>
<p>Must not be greater than 255 characters.</p>
        </p>
                <p>
            <b><code>remember_token</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
                <input type="text"
               name="remember_token"
               data-endpoint="POSTapi-residents"
               value="aopjvxtunhglizrwgjtnbvnkojpqc"
               data-component="body" hidden>
    <br>
<p>Must not be greater than 100 characters.</p>
        </p>
                <p>
            <b><code>created_at</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
                <input type="text"
               name="created_at"
               data-endpoint="POSTapi-residents"
               value=""
               data-component="body" hidden>
    <br>

        </p>
                <p>
            <b><code>updated_at</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
                <input type="text"
               name="updated_at"
               data-endpoint="POSTapi-residents"
               value=""
               data-component="body" hidden>
    <br>

        </p>
                <p>
            <b><code>estateCode</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
                <input type="text"
               name="estateCode"
               data-endpoint="POSTapi-residents"
               value="libero"
               data-component="body" hidden>
    <br>

        </p>
                <p>
            <b><code>meterNo</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
                <input type="text"
               name="meterNo"
               data-endpoint="POSTapi-residents"
               value="bjzpitiqaorcohyzifyqmei"
               data-component="body" hidden>
    <br>
<p>Must not be greater than 40 characters.</p>
        </p>
                <p>
            <b><code>dateMovedIn</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
                <input type="text"
               name="dateMovedIn"
               data-endpoint="POSTapi-residents"
               value="2021-11-06T00:42:13"
               data-component="body" hidden>
    <br>
<p>Must be a valid date.</p>
        </p>
                <p>
            <b><code>deleted_at</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
                <input type="text"
               name="deleted_at"
               data-endpoint="POSTapi-residents"
               value=""
               data-component="body" hidden>
    <br>

        </p>
        </form>

            <h2 id="endpoints-GETapi-residents--id-">Display the specified Resident.</h2>

<p>
</p>

<p>GET|HEAD /residents/{id}</p>

<span id="example-requests-GETapi-residents--id-">
<blockquote>Example request:</blockquote>


<pre><code class="language-bash">curl --request GET \
    --get "http://smartestateserver.test/api/residents/12" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre>

<pre><code class="language-javascript">const url = new URL(
    "http://smartestateserver.test/api/residents/12"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre>
</span>

<span id="example-responses-GETapi-residents--id-">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary>
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 44
access-control-allow-origin: *
 </code></pre>
        </details>         <pre>

<code class="language-json">{
    &quot;status&quot;: &quot;Authorization Token not found&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-residents--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-residents--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-residents--id-"></code></pre>
</span>
<span id="execution-error-GETapi-residents--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-residents--id-"></code></pre>
</span>
<form id="form-GETapi-residents--id-" data-method="GET"
      data-path="api/residents/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-residents--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-residents--id-"
                    onclick="tryItOut('GETapi-residents--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-residents--id-"
                    onclick="cancelTryOut('GETapi-residents--id-');" hidden>Cancel
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-residents--id-" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/residents/{id}</code></b>
        </p>
                    <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <p>
                <b><code>id</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
                <input type="number"
               name="id"
               data-endpoint="GETapi-residents--id-"
               value="12"
               data-component="url" hidden>
    <br>
<p>The ID of the resident.</p>
            </p>
                    </form>

            <h2 id="endpoints-PUTapi-residents--id-">Update the specified Resident in storage.</h2>

<p>
</p>

<p>PUT/PATCH /residents/{id}</p>

<span id="example-requests-PUTapi-residents--id-">
<blockquote>Example request:</blockquote>


<pre><code class="language-bash">curl --request PUT \
    "http://smartestateserver.test/api/residents/9" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"surname\": \"tlnpdobfqhkknyajrzcbvtf\",
    \"othernames\": \"qoftynoajoeupnjoqjkgzlekftaevonttfubpphdldboshlfclwdjbavzgwxhsjlmpjjuhlefysmrurmsgddnnhlwzszsjhcw\",
    \"phone\": \"rrzfiwtgnoabwn\",
    \"gender\": \"reiciendis\",
    \"email\": \"tyuajavtfbsawhjhdbvyxtorokmxwqnuxhfnlbfpzpohwsuuszhqvjcimyessifyrijlqnoqv\",
    \"remember_token\": \"klgjteszmsrpspesncf\",
    \"estateCode\": \"expedita\",
    \"meterNo\": \"oumqsdwnflaqtbkec\",
    \"dateMovedIn\": \"2021-11-06T00:42:13\"
}"
</code></pre>

<pre><code class="language-javascript">const url = new URL(
    "http://smartestateserver.test/api/residents/9"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "surname": "tlnpdobfqhkknyajrzcbvtf",
    "othernames": "qoftynoajoeupnjoqjkgzlekftaevonttfubpphdldboshlfclwdjbavzgwxhsjlmpjjuhlefysmrurmsgddnnhlwzszsjhcw",
    "phone": "rrzfiwtgnoabwn",
    "gender": "reiciendis",
    "email": "tyuajavtfbsawhjhdbvyxtorokmxwqnuxhfnlbfpzpohwsuuszhqvjcimyessifyrijlqnoqv",
    "remember_token": "klgjteszmsrpspesncf",
    "estateCode": "expedita",
    "meterNo": "oumqsdwnflaqtbkec",
    "dateMovedIn": "2021-11-06T00:42:13"
};

fetch(url, {
    method: "PUT",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre>
</span>

<span id="example-responses-PUTapi-residents--id-">
</span>
<span id="execution-results-PUTapi-residents--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-PUTapi-residents--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-residents--id-"></code></pre>
</span>
<span id="execution-error-PUTapi-residents--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-residents--id-"></code></pre>
</span>
<form id="form-PUTapi-residents--id-" data-method="PUT"
      data-path="api/residents/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('PUTapi-residents--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-PUTapi-residents--id-"
                    onclick="tryItOut('PUTapi-residents--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-PUTapi-residents--id-"
                    onclick="cancelTryOut('PUTapi-residents--id-');" hidden>Cancel
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-PUTapi-residents--id-" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-darkblue">PUT</small>
            <b><code>api/residents/{id}</code></b>
        </p>
            <p>
            <small class="badge badge-purple">PATCH</small>
            <b><code>api/residents/{id}</code></b>
        </p>
                    <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <p>
                <b><code>id</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
                <input type="number"
               name="id"
               data-endpoint="PUTapi-residents--id-"
               value="9"
               data-component="url" hidden>
    <br>
<p>The ID of the resident.</p>
            </p>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <p>
            <b><code>surname</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
                <input type="text"
               name="surname"
               data-endpoint="PUTapi-residents--id-"
               value="tlnpdobfqhkknyajrzcbvtf"
               data-component="body" hidden>
    <br>
<p>Must not be greater than 100 characters.</p>
        </p>
                <p>
            <b><code>othernames</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
                <input type="text"
               name="othernames"
               data-endpoint="PUTapi-residents--id-"
               value="qoftynoajoeupnjoqjkgzlekftaevonttfubpphdldboshlfclwdjbavzgwxhsjlmpjjuhlefysmrurmsgddnnhlwzszsjhcw"
               data-component="body" hidden>
    <br>
<p>Must not be greater than 100 characters.</p>
        </p>
                <p>
            <b><code>phone</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
                <input type="text"
               name="phone"
               data-endpoint="PUTapi-residents--id-"
               value="rrzfiwtgnoabwn"
               data-component="body" hidden>
    <br>
<p>Must not be greater than 14 characters.</p>
        </p>
                <p>
            <b><code>gender</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
                <input type="text"
               name="gender"
               data-endpoint="PUTapi-residents--id-"
               value="reiciendis"
               data-component="body" hidden>
    <br>

        </p>
                <p>
            <b><code>email</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
                <input type="text"
               name="email"
               data-endpoint="PUTapi-residents--id-"
               value="tyuajavtfbsawhjhdbvyxtorokmxwqnuxhfnlbfpzpohwsuuszhqvjcimyessifyrijlqnoqv"
               data-component="body" hidden>
    <br>
<p>Must not be greater than 255 characters.</p>
        </p>
                <p>
            <b><code>remember_token</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
                <input type="text"
               name="remember_token"
               data-endpoint="PUTapi-residents--id-"
               value="klgjteszmsrpspesncf"
               data-component="body" hidden>
    <br>
<p>Must not be greater than 100 characters.</p>
        </p>
                <p>
            <b><code>created_at</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
                <input type="text"
               name="created_at"
               data-endpoint="PUTapi-residents--id-"
               value=""
               data-component="body" hidden>
    <br>

        </p>
                <p>
            <b><code>updated_at</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
                <input type="text"
               name="updated_at"
               data-endpoint="PUTapi-residents--id-"
               value=""
               data-component="body" hidden>
    <br>

        </p>
                <p>
            <b><code>estateCode</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
                <input type="text"
               name="estateCode"
               data-endpoint="PUTapi-residents--id-"
               value="expedita"
               data-component="body" hidden>
    <br>

        </p>
                <p>
            <b><code>meterNo</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
                <input type="text"
               name="meterNo"
               data-endpoint="PUTapi-residents--id-"
               value="oumqsdwnflaqtbkec"
               data-component="body" hidden>
    <br>
<p>Must not be greater than 40 characters.</p>
        </p>
                <p>
            <b><code>dateMovedIn</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
                <input type="text"
               name="dateMovedIn"
               data-endpoint="PUTapi-residents--id-"
               value="2021-11-06T00:42:13"
               data-component="body" hidden>
    <br>
<p>Must be a valid date.</p>
        </p>
                <p>
            <b><code>deleted_at</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
                <input type="text"
               name="deleted_at"
               data-endpoint="PUTapi-residents--id-"
               value=""
               data-component="body" hidden>
    <br>

        </p>
        </form>

            <h2 id="endpoints-DELETEapi-residents--id-">Remove the specified Resident from storage.</h2>

<p>
</p>

<p>DELETE /residents/{id}</p>

<span id="example-requests-DELETEapi-residents--id-">
<blockquote>Example request:</blockquote>


<pre><code class="language-bash">curl --request DELETE \
    "http://smartestateserver.test/api/residents/19" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre>

<pre><code class="language-javascript">const url = new URL(
    "http://smartestateserver.test/api/residents/19"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers,
}).then(response =&gt; response.json());</code></pre>
</span>

<span id="example-responses-DELETEapi-residents--id-">
</span>
<span id="execution-results-DELETEapi-residents--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-DELETEapi-residents--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-residents--id-"></code></pre>
</span>
<span id="execution-error-DELETEapi-residents--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-residents--id-"></code></pre>
</span>
<form id="form-DELETEapi-residents--id-" data-method="DELETE"
      data-path="api/residents/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('DELETEapi-residents--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-DELETEapi-residents--id-"
                    onclick="tryItOut('DELETEapi-residents--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-DELETEapi-residents--id-"
                    onclick="cancelTryOut('DELETEapi-residents--id-');" hidden>Cancel
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-DELETEapi-residents--id-" hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-red">DELETE</small>
            <b><code>api/residents/{id}</code></b>
        </p>
                    <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <p>
                <b><code>id</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
                <input type="number"
               name="id"
               data-endpoint="DELETEapi-residents--id-"
               value="19"
               data-component="url" hidden>
    <br>
<p>The ID of the resident.</p>
            </p>
                    </form>

    

        
    </div>
    <div class="dark-box">
                    <div class="lang-selector">
                                    <a href="#" data-language-name="bash">bash</a>
                                    <a href="#" data-language-name="javascript">javascript</a>
                            </div>
            </div>
</div>
<script>
    $(function () {
        var exampleLanguages = ["bash","javascript"];
        setupLanguages(exampleLanguages);
    });
</script>
</body>
</html>