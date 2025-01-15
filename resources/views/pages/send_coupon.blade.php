<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gửi mã khuyến mãi cho khách vip</title>
</head>
<body>
  <div class="coupon">
        <div class="container">
            <h3>Mã khuyến mãi từ shop</h3>
        </div>
        <div class="container">
            <h2 class="note"><b><i>
            @if ($coupon['coupon_condition']==1)
                Giảm {{$coupon['coupon_number']}}%
            @else
                 Giảm {{number_format($coupon['coupon_number'],0,',','.')}}k
            @endif     
            tổng đơn hàng trên 2 triệu</i></b></h2>
            <p>Quý khách đã từng mua hàng tại shop</p>
        </div>
        <div class="container">
            <p>Sử dụng code sau: <span>{{$coupon['coupon_code']}}</span> bắt đầu từ {{$coupon['start_coupon']}}</p>
            <p>Ngày hết hạn: {{$coupon['end_coupon']}}</p>
        </div>
  </div>
</body>
</html>