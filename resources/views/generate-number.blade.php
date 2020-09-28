<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>generate number</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@800&display=swap" rel="stylesheet">
    <style>
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
            background-color: skyblue;
        }
        .wrapper-slot .slot-box{
            position: relative;
            margin: 10px;
            width: 200px;
            height: 200px;
            text-align: center;
            background-color: antiquewhite;
        }
        .wrapper-slot .slot-box .slot{
            position: absolute;
            top: 10px;
            left: 10px;
            width: 180px;
            height: 180px;
            overflow-y: hidden;
            background-color: skyblue;
        }
        .wrapper-slot .slot-box .slot > div {
            margin: 5px;
            width: 170px;
            height: 170px;
            border-radius: 12px;
            font-family: 'Roboto Slab', serif;
            font-size: 42pt;
            line-height: 170px;
            transform: translate3d(0, 0, 0);
            transition: all 2s;
        }

        .wrapper-slot .slot-box:nth-child(odd) .slot > div{
            background-color: rgba(255, 87, 34, .4);
            
        }
        .wrapper-slot .slot-box:nth-child(even) .slot > div{
            background-color: rgba(255, 235, 59,.4);
            
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
            border: solid 4px antiquewhite;
            padding : .6em 1em;
            background: skyblue;
            color: antiquewhite;
            font-family: 'Roboto Slab', serif;
            font-size:16pt;
        }
    </style>
</head>
<body>
    <div class="section">
     <div class="container">
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
        <form onsubmit="generate()">
            <div class="flex-wrap">
                <div class="form-group">
                    <label for="digits">Digits</label>
                    <input required class="form-control" type="number" name="digits" id="digits" min="1" max="4" value="1">
                </div>
                <div class="form-group">
                    <label for="min">Min Number</label>
                    <input class="form-control" type="number" name="min" id="min" min="1" max="9998">
                </div>
                <div class="form-group">
                    <label for="max">Max Number</label>
                    <input class="form-control" type="number" name="max" id="max" min="1" max="9999">
                </div>
            </div>
            <div class="form-group">
                <button>Generate New Number</button>
            </div>
        </form>
     </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        var number = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9];
        var render = '';
        var degree = 0, timer;
        function generate() {
            var min = parseInt($('input[name=min]').val());
            var max = parseInt($('input[name=max]').val());
            var digits = $('input[name=digits]').val();
            if (min > max) {
                alert('minimal number tidak boleh lebih besar dari maksimal number');
                return false;
            }
            if (min >= 10 && digits == 1) { 
                digits = 2;
                $('input[name=digits]').val(digits);
            }
            else if (min >= 100 && digits == 2) { 
                digits = 3;
                $('input[name=digits]').val(digits);
            }
            else if (min >= 1000 && digits == 3) { 
                digits = 4;
                $('input[name=digits]').val(digits);
            }
            if (degree > 359) { degree = 0 }
            $('.wrapper-slot .slot-box .slot div').html('0');
            var findElem = [];
            var countElem = 0;
            for (i = 1; i <= digits; i++) {
                findElem[i] = '.wrapper-slot .slot-box'+i+' .slot';
                countElem = i;
            }
            rand($(findElem[1]), countElem, 1);
            event.preventDefault();
        }

        function rand(selector, countElem, currentElem) {
            var randomItem = number[Math.floor(Math.random()*number.length)];
            selector.css({ WebkitTransform: "rotatex("+degree+"deg)" });
            selector.css({ '-moz-transform': "rotatex("+degree+"deg)" });
            selector.find('div').html(randomItem);
            timer = setTimeout(function() { 
                if (degree == 360) { 
                    if (currentElem != countElem) { 
                        degree = 0;
                        currentElem += 1;
                        rand($('.wrapper-slot .slot-box'+currentElem+' .slot'), countElem, currentElem); 
                    }else{
                        checkResult();
                    }
                }
                else{ rand(selector, countElem, currentElem); }
                ++degree; 
            },5);
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
            if (res > max && max > 0) { generate() }
        }
    </script>
</body>
</html>