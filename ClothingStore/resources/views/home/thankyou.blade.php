@include('home.header')
<!-- start -->
<div style="text-align: center; margin-top: 20px;">
    <h1 style="font-size: 36px; color: #CA1515; font-family: 'Cookie', cursive; padding-top: 20px;">Thank you for ordering!</h1>
    <p style="font-size: 24px; color: #333; padding-top: 40px;">This is your purchase code: <span style="font-weight: bold; color: #CA1515;">{{$purchase_code}}</span></p>
    <a href="{{route('orders')}}" class="btn btn-primary" style="font-size: 20px; margin-top: 20px; margin-bottom: 20px;">View Your Orders</a>
</div>
<!-- end -->
@include('home.footer')
