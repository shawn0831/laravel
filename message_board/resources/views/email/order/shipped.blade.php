<!-- View Data -->
<!-- ============================================================= -->
<!-- Via Public Properties -->
<div>
    Price: {{ $order->price }}
</div>

<!-- Via The with Method: -->
<div>
    Price: {{ $orderPrice }}
</div>

<!-- Inline Attachments -->
<!-- ============================================================= -->
<body>
    Here is an image:

    <img src="{{ $message->embed($pathToImage) }}">
</body>

<!-- Embedding Raw Data Attachments -->
<body>
    Here is an image from raw data:

    <img src="{{ $message->embedData($data, $name) }}">
</body>