<div>
    plan: {{ $order->name }}
    <br>
    thanks for your subscript!
    <br>
    感謝你的訂閱!
    <?php $imagePath = asset('image/tape.png') ?>
    <img src="{{ $message->embed($imagePath) }}">
</div>