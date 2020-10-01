<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>generate number</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@800&display=swap" rel="stylesheet">
    <style>
        body{
            background-color: #B8B8B8;
            margin: 0;
        }
        .section{
            position:relative;
            padding-top:2em;
            padding-bottom:2em;
        }
        .container{
            position:relative;
            margin: 0 auto;
            width: 1000px;
        }
        .flex-wrap{
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }
        .wrapper-slot{
            background-color: #000000;
            border: solid #FFFFFF 4px;
        }
        .wrapper-slot .slot-box{
            position: relative;
            margin: 10px;
            width: 200px;
            height: 200px;
            text-align: center;
            background-color: #B8B8B8;
            border-radius: 8px;
        }
        .wrapper-slot .slot-box .slot{
            position: absolute;
            top: 10px;
            left: 10px;
            width: 180px;
            height: 180px;
            overflow-y: hidden;
            background-color: #FFFFFF;
            border-radius: 8px;
        }
        .wrapper-slot .slot-box .slot > div {
            margin: 5px;
            width: 170px;
            height: 170px;
            border-radius: 12px;
            font-family: 'Roboto Slab', serif;
            font-size: 42pt;
            color: #FFFFFF;
            line-height: 170px;
            transform: translate3d(0, 0, 0);
            transition: all 2s;
            background-color: #333333;
        }

        .form-group{
            line-height: 2;
            padding-left:1em;
            padding-right:1em;
            margin-bottom: 1em;
        }
        .form-control {
            display: block;
            width: 100%;
            height: calc(2.25rem + 2px);
            padding: .375rem .75rem;
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            color: #495057;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #ced4da;
            border-radius: .25rem;
            box-shadow: inset 0 0 0 transparent;
            transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
        }
        button{
            cursor:pointer;
            display:block;
            width:100%;
            text-align: center;
            border-radius: 3px;
            border: solid 4px #FFFFFF;
            padding : .6em 1em;
            background: #333333;
            color: #FFFFFF;
            font-family: 'Roboto Slab', serif;
            font-size:16pt;
        }
        img {
            height: 60px;
        }
        .text-center{
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="section">
     <div class="container">
        <div class="text-center">
            <img src="{{ asset('images/logo_agenlive4d.png') }}" alt="logo">
        </div>
        <div class="flex-wrap wrapper-slot">
            <div class="slot-box slot-box4">
                <div class="slot"><div>0</div></div>
            </div>
            <div class="slot-box slot-box3">
                <div class="slot"><div>0</div></div>
            </div>
            <div class="slot-box slot-box2">
                <div class="slot"><div>0</div></div>
            </div>
            <div class="slot-box slot-box1">
                <div class="slot"><div>0</div></div>
            </div>

        </div>
        <div class="flex-wrap">
            <div class="form-group">
                <label for="digits">Digits</label>
                <input readonly class="form-control" type="number" name="digits" id="digits" min="1" max="4" value="{{ $setting['digits'] }}">
            </div>
            <div class="form-group">
                <label for="min">Min Number</label>
                <input readonly  class="form-control" type="number" name="min" id="min" min="1" max="9998" value="{{ $setting['min'] }}">
            </div>
            <div class="form-group">
                <label for="max">Max Number</label>
                <input readonly  class="form-control" type="number" name="max" id="max" min="1" max="9999" value="{{ $setting['max'] }}">
            </div>
        </div>
        <div class="form-group">
            <button onclick="generate()">Generate New Number</button>
        </div>
     </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

        var number = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9];
        var degree = 0, timer;
        var run = false;
        var min = "{{ $setting['min'] }}";
        var max = "{{ $setting['max'] }}";
        var digits = "{{ $setting['digits'] }}";

        function sendRequest(target,input) {
            var responseData = null;
            $.ajax({
                url: target,
                type: 'post',
                dataType: 'json',
                data: input,
                success: function(data) { 
                    responseRequest(data);
                }
            });
            return responseData;
        }

        function responseRequest(data) {
            if (data.generate_animate == true) { animate(data.generate_animate_data) }
        }

        function checkGenerateCache() { sendRequest('{{ route("generate.cache") }}',null); }

        function procesingGenerate() {
            run = true;
            $('button').hide();
        }
        function endGenerate() {
            run = false;
            $('button').show();
        }
        function generate() {
            procesingGenerate();
            // var min = parseInt($('input[name=min]').val());
            // var max = parseInt($('input[name=max]').val());
            // var digits = $('input[name=digits]').val();
            // if (min > max) {
            //     endGenerate();
            //     alert('minimal number tidak boleh lebih besar dari maksimal number');
            //     return false;
            // }
            // if (digits < max.toString().length) {
            //     max = '';
            //     for (i = 0; i <= digits; i++) { max += '9'; }
            //     max = parseInt(max);
            // }
            checkGenerateCache();
        }
        
        function animate(data) {
            var randomValue = data.new_numb;
            // var randomValue = Math.floor(Math.random() * (max - min + 1) + min);
            randomValue = randomValue.toString();
            if (randomValue.length < digits) {
                for (i = 0; i <= digits-randomValue.length; i++){
                    randomValue = '0'+randomValue;
                }
            }
            if (min >= 10 && digits == 1 ) {  digits = 2; }
            else if (min >= 100 && digits == 2) {  digits = 3; }
            else if (min >= 1000 && digits == 3) {  digits = 4; }
            if (max <= 10 && digits >= 2  ) {  digits = 1; }
            else if (max <= 100 && digits >= 3) {  digits = 2; }
            else if (max <= 1000 && digits == 4) {  digits = 3; }
            $('input[name=digits]').val(digits);
            if (degree > 359) { degree = 0 }
            $('.wrapper-slot .slot-box .slot div').html('0');
            var findElem = [];
            var valuElem = [];
            var countElem = 0;
            for (i = 1; i <= digits; i++) {
                var ranArrVal = randomValue.slice((i-1),i);
                findElem[i] = '.wrapper-slot .slot-box'+i+' .slot';
                valuElem[i] =  ranArrVal;
                countElem = i;
            }
            rand($(findElem[countElem]), countElem, countElem, valuElem, 1);
            event.preventDefault();
            
        }

        function rand(selector, countElem, currentElem, valuElem, valQue) {
            var randomItem = number[Math.floor(Math.random()*number.length)];
            selector.css({ WebkitTransform: "rotatex("+degree+"deg)" });
            selector.css({ '-moz-transform': "rotatex("+degree+"deg)" });
            selector.find('div').html(randomItem);
            timer = setTimeout(function() { 
                if (degree == 360) { 
                    selector.find('div').html(valuElem[valQue]);
                    if (currentElem != 1) { 
                        degree = 0;
                        currentElem -= 1;
                        valQue += 1;
                        rand($('.wrapper-slot .slot-box'+currentElem+' .slot'), countElem, currentElem, valuElem, valQue); 
                    }else{
                        checkResult();
                    }
                }
                else{ rand(selector, countElem, currentElem, valuElem, valQue); }
                ++degree; 
            },1);
        }

        function checkResult() {
            var res = '';
            var min = parseInt($('input[name=min]').val());
            var max = parseInt($('input[name=max]').val());
            $.each($('.wrapper-slot .slot-box .slot'),function(){
                res+=$(this).find('div').html();
            });
            res = parseInt(res);
            if (res < min && min > 0) { generate() }
            else if (res > max && max > 0) { generate() }
            else { endGenerate() }
        }
    </script>
</body>
</html>