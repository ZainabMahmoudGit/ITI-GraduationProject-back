{{-- @dd($order) --}}
<p>Hello Dear customer {{$order->user->name}}</p>
<p>your order heve been accepted you have to pay   for complete your payment request follow payment mail</p>

http://127.0.0.1:8000/payment/{{$order->id}}
