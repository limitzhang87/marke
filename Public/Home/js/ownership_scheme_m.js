
    /**
     * 点击按钮生成图片
     */
    $('#loadpic').on('click', function() {

        var name = $('span[class="name"]').html();

        /**
         * 将栋 单元 房号的值(本为ID)换成其对应的名称
         */
        var b_name = $('option[value="'+b_id+'"]').html();
        $('option[value="'+b_id+'"]').val(b_name);

        var u_name = $('option[value="'+u_id+'"]').html();
        $('option[value="'+u_id+'"]').val(u_name);

        var room_number = $('option[value="'+r_id+'"]').html();
        $('option[value="'+r_id+'"]').val(room_number);
        $.ajax({
            type: "POST",
            url: ThinkPHP.APP + '/Home/OwnerShip/index',
            data: $('#ac_form').serialize(), //选择表单内的数据发送
            error: function(request) {
                alert("提交失败！");
            },
            success: function(msg) {
                if (msg.error == '0') {
                    $('#none').remove();
                    //生成图片之后直接跳转到分享页面
                    window.location.href=ThinkPHP.APP + "/Home/Share/ownership_pic_show/houses/"+msg.path.houses+"/id/"+msg.path.id ;
                    return;
                        var item =  msg.path;
                        var html = '<div id="pic_title" name="pic_title_' + item.id + '">' +
                            '<span data-toggle="modal" data-target="#show_pic" onclick="show_pic_fun(\'' + item.path + '\')" data-url="' + item.path + '"> ' 
                            +item.created_time + '</span>'+
                            '<button type="button" class="close" onclick="del_own_pic(\'' + item.id + '_' + item.path + '\')" >×</button>' +
                            '</div>';

                        $('#add_pic').prepend(html);
                        $('#remind').show();
                        setTimeout("$('#remind').hide()", 3000);
                } else {
                    alert(msg.msg);
                }
            },
            comolete:function(){
                $('option[value="'+b_name+'"]').val(b_id);
                $('option[value="'+u_name+'"]').val(u_id);
                $('option[value="'+room_number+'"]').val(r_id);
            }
        });
    });

    function is_0($value){
        if($value == 0){
            return '';
        }else if($value == NaN){
            return '';
        }else{
            return $value;
        }
    }
    //START 楼号处理======
    var _building = '';
    var _unit     = '';
    var _room     = '';
    var b_id = '';
    var u_id = '';
    var r_id = '';
    var type ='';
    $(function(){
        if(type == '1'){
            selectFirst();
        }else{
            roomChange();
        }

        $('#building').change(function(){
            b_id = $(this).val();
            buildingChange();
        });

        $('#unit').change(function(){
            u_id = $(this).val();
            unitChange();
        });

        $('#room').change(function(){
            r_id = $(this).val();
            roomChange();
        });
    })

    /**
     * 如果是从房号详情页跳转过来的，带着房号ID，
     * 则需要在置业计划表中选中该房号的栋号，单元号等。
     * @return {[type]} [description]
     */
    function selectFirst(){
        //修改栋号选中
        $('#building>option[value="'+b_id+'"]').attr("selected", true);
        var newUnit = _unit[b_id];
        if(newUnit== undefined){/*选定的栋号下没有单元数据*/
            $('#unit').html('');
            $('#room').html('');
        }else{
            var unitHtml = '';//<option value="{$unit.id}">{$unit.u_name}</option>
            $.each(newUnit,function(i,item){
                if(i == u_id){
                    unitHtml += '<option value="'+item.id + '" selected="selected">'+ item.u_name + '</option>';
                }else{
                    unitHtml += '<option value="'+ item.id + '">'+ item.u_name + '</option>';
                }
            })
            $('#unit').html(unitHtml);
        }
        var newRoom = _room[u_id];
        if(newRoom== undefined){/*选定的栋号下没有单元数据*/
            $('#room').html('');
        }else{
            var roomHtml = '';//<option value="{$unit.id}">{$unit.u_name}</option>
            $.each(newRoom,function(i,item){
                if(i == r_id){
                    roomHtml += '<option value="'+ item.id + '" selected="selected">'+ item.room_number + '</option>';
                }else{
                    roomHtml += '<option value="'+ item.id + '">'+ item.room_number + '</option>';
                }
            })
            $('#room').html(roomHtml);
        }
        roomChange();
    }
    /**
     * 栋号改变时触发
     * 修改单元下拉框
     */
    function buildingChange(){
        if(_unit == ''){
            $('#unit').html('');
            $('#room').html('');
            return ;
        }
        var newUnit = _unit[b_id];
        if(newUnit== undefined){/*选定的栋号下没有单元数据*/
            $('#unit').html('');
            $('#room').html('');
        }else{
            var unitHtml = '';//<option value="{$unit.id}">{$unit.u_name}</option>
            var k = 0;
            $.each(newUnit,function(i,item){
                if(k == 0){
                    u_id = item.id;
                }
                unitHtml += '<option value="'+ item.id + '">'+ item.u_name + '</option>';
                k++;
            })
            $('#unit').html(unitHtml);
            unitChange();
        }
    }

    /**
     * 栋号改变时触发
     * 修改房号信息
     * @return {[type]} [description]
     */
    function unitChange(){
        if(_room == ''){
            $('#room').html('');
            console.log(1);
            return ;
        }else{
            console.log(2);
        }
        var newRoom = _room[u_id];
        if(newRoom== undefined){/*选定的栋号下没有单元数据*/
            $('#room').html('');
        }else{
            var roomHtml = '';//<option value="{$unit.id}">{$unit.u_name}</option>
            var k = 0;
            $.each(newRoom,function(i,item){
                if(k == 0){
                    r_id = item.id;
                }
                roomHtml += '<option value="'+  item.id + '">'+ item.room_number + '</option>';
                k++;
            })
            $('#room').html(roomHtml);
            roomChange();
        }
    }


    /**
     * 房号改变时触发
     * @return {[type]} [description]
     */
    function roomChange(){
        if(_room == '' || _room == null || _room[u_id] == null){
            return ;
        }
        var area         = _room[u_id][r_id]['area'];
        var unit_price   = _room[u_id][r_id]['unit_price'];
        var usable_area  = _room[u_id][r_id]['usable_area'];
        var usable_price = _room[u_id][r_id]['usable_price'];

        if(is_0(usable_area) == ''){
            var pool_area  = 0;
        }else{
            var pool_area  = area - usable_area;
        }

        if( area != '' && unit_price != ''){
            var total_price = parseFloat(area) * parseFloat(unit_price);
        }else if( usable_area != '' && usable_price != '' ){
            var total_price = parseFloat(usable_area) * parseFloat(usable_price);
        }else{

        }
        $('input[name="area"]').val( is_0(area));
        $('input[name="unit_price"]').val(is_0(unit_price));
        $('input[name="usbale_area"]').val(is_0(usable_area));
        $('input[name="usbale_unit_price"]').val(is_0(usable_price));
        $('input[name="pool_area"]').val(is_0(pool_area));
        $('input[name="total_price_pre"]').val(is_0(total_price));
        $('input[name="total_price_now"]').val( is_0(total_price*$('input[name="total_price_discount"]').val()/100));
        $('input[name="downpayment_1"]').val(is_0(total_price*$('input[name="total_price_discount"]').val()/100));
    }
    //END 楼号处理======

    $(function() {
        /**
         * 选择 楼号下拉框还是手动输入
         */
        $('#house_radio1').click(function() {
            $('tr[name="house_tr_1"]').each(function(i,e){
                $(e).show();
            });
            $('tr[name="house_tr_2"]').each(function(i,e){
                $(e).hide();
            });
        });

        $('#house_radio2').click(function() {
            $('tr[name="house_tr_1"]').each(function(i,e){
                $(e).hide();
            });
            $('tr[name="house_tr_2"]').each(function(i,e){
                $(e).show();
            });
        });
        /**
         * 建筑面积修改时，总价也修改
         * 要做两手判断，判断总价是否有填写，如果填写，这根据总价修改单价面积
         * 如果总价没有填写，则根据面积填写总价
         * @return {[type]}     [description]
         */
        $('input[name="area"]').bind('input propertychange', function() {
            var area = parseInt($(this).val());
            var total_price_now = $('input[name="total_price_now"]').val();
            if (total_price_now == '' || parseInt(total_price_now) == 0) {
                var unit_price = parseInt($('input[name="unit_price"]').val());
                var total_price_discount = parseInt($('input[name="total_price_discount"]').val());

                var total_price_now = isNaN(unit_price * area) ? 0 : (unit_price * area);
                var total_price_pre = isNaN(unit_price * area * total_price_discount / 100) ? 0 : (unit_price * area * total_price_discount / 100);
                var downpayment_1 = total_price_now;

                $('input[name="total_price_now"]').val(is_0(total_price_now));
                $('input[name="total_price_pre"]').val(is_0(total_price_pre));
                $('input[name="downpayment_1"]').val(is_0(downpayment_1));
            } else {
                var unit_price = total_price_now / area;
                $('input[name="usbale_unit_price"]').val(is_0(unit_price.toFixed(2)));

            }
        });

        /**
         * 套内面积修改时，总价也修改
         * 要做两手判断，判断总价是否有填写，如果填写，这根据总价修改单价面积
         * 如果总价没有填写，则根据面积填写总价
         * @return {[type]}     [description]
         */
        // $('input[name="usbale_area"]').bind('input propertychange', function() {
        //     var usbale_area = parseInt($(this).val());
        //     var total_price_now = $('input[name="total_price_now"]').val();
        //     if (total_price_now == '' || parseInt(total_price_now) == 0) {
        //         var usbale_unit_price = parseInt($('input[name="usbale_unit_price"]').val());
        //         var total_price_discount = parseInt($('input[name="total_price_discount"]').val());

        //         var total_price_now = isNaN(usbale_unit_price * usbale_area) ? 0 : (usbale_unit_price * usbale_area);
        //         var total_price_pre = isNaN(usbale_unit_price * usbale_area * total_price_discount / 100) ? 0 : (usbale_unit_price * usbale_area * total_price_discount / 100);
        //         var downpayment_1 = total_price_now;

        //         $('input[name="total_price_now"]').val(total_price_now);
        //         $('input[name="total_price_pre"]').val(total_price_pre);
        //         $('input[name="downpayment_1"]').val(downpayment_1);
        //     } else {
        //         var usbale_unit_price = total_price_now / usbale_area;
        //         $('input[name="usbale_unit_price"]').val(usbale_unit_price.toFixed(2));

        //     }
        // });

        /**
         * 建筑单价被修改是总价也修改
         * @param  {[type]} ){                       var unit_price [description]
         * @return {[type]}     [description]
         */
        $('input[name="unit_price"]').bind('input propertychange', function() {
            var unit_price = parseInt($(this).val());
            var area = parseInt($('input[name="area"]').val());
            var total_price_discount = parseInt($('input[name="total_price_discount"]').val());

            var total_price_now = isNaN(unit_price * area) ? 0 : (unit_price * area);
            var total_price_pre = isNaN(unit_price * area * total_price_discount / 100) ? 0 : (unit_price * area * total_price_discount / 100);
            var downpayment_1 = total_price_now;

            $('input[name="total_price_now"]').val(is_0(total_price_now));
            $('input[name="total_price_pre"]').val(is_0(total_price_pre));
            $('input[name="downpayment_1"]').val(is_0(downpayment_1));
        });

        /**
         * 套内单价被修改是总价也修改
         * @return {[type]}     [description]
         */
        // $('input[name="usbale_unit_price"]').bind('input propertychange', function() {
        //     var usbale_unit_price = parseInt($(this).val());
        //     var usbale_area = parseInt($('input[name="usbale_area"]').val());
        //     var total_price_discount = parseInt($('input[name="total_price_discount"]').val());

        //     var total_price_now = isNaN(usbale_unit_price * usbale_area) ? 0 : (usbale_unit_price * usbale_area);
        //     var total_price_pre = isNaN(usbale_unit_price * usbale_area * total_price_discount / 100) ? 0 : (usbale_unit_price * usbale_area * total_price_discount / 100);
        //     var downpayment_1 = total_price_now;

        //     $('input[name="total_price_now"]').val(total_price_now);
        //     $('input[name="total_price_pre"]').val(total_price_pre);
        //     $('input[name="downpayment_1"]').val(downpayment_1);
        // });


        /**
         * 原总价发生改变的时候"成交总价"和"建筑面积单价"改变
         */
        $('input[name="total_price_pre"]').bind('input propertychange', function() {
            var total_price_pre = parseInt($(this).val());
            var total_price_discount = parseInt($('input[name="total_price_discount"]').val());
            var total_price_now = total_price_pre * total_price_discount / 100;

            var area = parseInt($('input[name="area"]').val());
            var unit_price = isNaN(total_price_now / area) ? 0 : total_price_now / area;

            var usbale_area = parseInt($('input[name="usbale_area"]').val());
            var usbale_unit_price = isNaN(total_price_now / usbale_area) ? 0 : total_price_now / usbale_area;

            $('input[name="unit_price"]').val(is_0(unit_price.toFixed(2)));
            $('input[name="usbale_unit_price"]').val(is_0(usbale_unit_price.toFixed(2)));
            $('input[name="total_price_now"]').val(is_0(total_price_now.toFixed(2)));
            $('input[name="downpayment_1"]').val(is_0(total_price_now.toFixed(2)));
        });

        /**
         * 三种付款方式的显示与隐藏
         * 选着一种，其余的两种要隐藏
         * @return {[type]}     [description]
         */
        $('#radio1').click(function() {
            $('#div_pay_1').show();
            $('#div_pay_2').hide();
            $('#div_pay_3').hide();
        });
        $('#radio2').click(function() {
            $('#div_pay_1').hide();
            $('#div_pay_2').show();
            $('#div_pay_3').hide();
        });
        $('#radio3').click(function() {
            $('#div_pay_1').hide();
            $('#div_pay_2').hide();
            $('#div_pay_3').show();
        });

        /**
         * 填写折扣时实时修改折扣后的价格
         */
        $('input[name="total_price_discount"]').bind('input propertychange', function() {
            var total_price_pre = $('input[name="total_price_pre"]').val();
            var total_price_discount = $(this).val();
            if(total_price_discount == ''){
                 total_price_discount = 0;
            }
            var total_price_now = parseInt(total_price_pre) * parseInt(total_price_discount) / 100;
            $('input[name="total_price_now"]').val(is_0(total_price_now.toFixed(2)));
            $('input[name="downpayment_1"]').val(is_0(total_price_now.toFixed(2)));
        });


        /**
         * 修改折后总价时原总价和折扣变化
         */
        $('input[name="total_price_now"]').bind('input propertychange', function() {
            //获取总价，计算折扣

            var total_price_now = $(this).val();
            var total_price_pre = $('input[name="total_price_pre"]').val();
            if(total_price_now == ''){
                 total_price_now = 0;
            }
            var total_price_discount = total_price_now/total_price_pre;
            $('input[name="total_price_discount"]').val((total_price_discount.toFixed(2)));
            $('input[name="downpayment_1"]').val(total_price_now);
        });

        /**
         * 分期付款中修改期款
         */
        $('select[name="percent_2[]"]').each(function(i) {
            $(this).change(function() {
                if (i == 1) {
                    var value0 = parseInt($('select[name="percent_2[]"]').eq(0).val());
                    var value1 = parseInt($('select[name="percent_2[]"]').eq(1).val());
                    if (value0 == '') {
                        alert('您还没有选择首期款！');
                        $('select[name="percent_2[]"]').eq(1).children().eq(0).attr('selected', 'selected');
                        return;
                    }
                    $('select[name="percent_2[]"]').eq(2).html('<option value="' + (100 - value0 - value1) + '">' + (100 - value0 - value1) / 10 + '成</option>');
                    $('input[name="downpayment_2[]"]').eq(2).val($('select[name="percent_2[]"]').eq(2).val() * $('input[name="total_price_now"]').val() / 100);
                } else if (i == 2) {
                    var value1 = $('select[name="percent_2[]"]').eq(1).val();
                    if (value1 == '') {
                        alert('您还没有选择第二期房款！');
                        $('select[name="percent_2[]"]').eq(2).children().eq(0).attr('selected', 'selected');
                        return;
                    }
                }
                $('input[name="downpayment_2[]"]').eq(i).val(parseInt($(this).val() * $('input[name="total_price_now"]').val()) / 100);
            });
        });

        /**
         * 银行按揭
         */
        $('select[name="percent_3"]').change(function() {
            var downpayment_3 = $(this).val() * $('input[name="total_price_now"]').val() / 100;
            var loan_value = $('input[name="total_price_now"]').val() - downpayment_3;
            var dif = loan_value % 1000;
            downpayment_3 += dif;
            loan_value -= dif;
            $('input[name="downpayment_3"]').val(downpayment_3.toFixed(2));
            $('input[name="loan_value"]').val(loan_value.toFixed(2));
        });
    });

    /**
     * 选择年率利
     * @param  {[type]} value [description]
     * @return {[type]}       [description]
     */
    function changeRate(value) {
        switch (value) {
            case '28':
                $('input[name="rate"]').val(5.67);
                break;
            case '27':
                $('input[name="rate"]').val(4.38);
                break;
            case '26':
                $('input[name="rate"]').val(3.61);
                break;
            case '25':
                $('input[name="rate"]').val(5.15);
                break;
        }
    }
    /**
     * 计算房贷
     */
    $('input[name="calcdivate_total"]').on('click', function() {
        var credit_total = $('input[name="loan_value"]').val();
        if (credit_total == '') {
            var HTML = '<span style="color:red;" id="tip">首付款没填</span>';
            $(this).after(HTML);
        } else {
            $('#tip').remove();
            var rate = $('input[name="rate"]').val();
            var year = $('select[name="year"]').val();
            var $msg = new Array();
            $msg['rate'] = rate;
            $msg['year'] = year;
            $msg['credit'] = credit_total;
            calculate_total($msg);
            return;
            $.ajax({
                type: "POST",
                url: "Credit-AJAX_calculate_total",
                data: 'credit_total=' + credit_total + '&rate=' + rate + '&year=' + year,
                async: false,
                error: function(request) {
                    alert("Connection error");
                },
                success: function(data) {
                    if (data.error == 0) {
                        showhtml(data.data);
                    }
                }
            });
        }
    });

    /**
     * 填写契约的利率的时候触发
     */
    $('input[name="contract_rate"]').bind('input propertychange', function() {
        var total_price_now = $('input[name="total_price_now"]').val();
        var contract_rate = $(this).val();
        if (total_price_now == '') {
            $('#tip_contract').html('成交总价没有填写');
        } else {
            $('#tip_contract').html('');
            var contract = total_price_now * contract_rate / 100;
            $('input[name="contract"]').val(isNaN(contract) ? 0 : contract.toFixed(2));
        }
    });

    $('#contract_rate_select').change(function(){
         var total_price_now = $('input[name="total_price_now"]').val();
        $('input[name="contract_rate"]').val($(this).val());
        var contract_rate = $(this).val();
         if (total_price_now == '') {
            $('#tip_contract').html('成交总价没有填写');
        } else {
            $('#tip_contract').html('');
            var contract = total_price_now * contract_rate / 100;
            $('input[name="contract"]').val(isNaN(contract) ? 0 : contract.toFixed(2));
        }
    })

    /**
     * 填写公共维修基金是触发
     */
    $('input[name="maintenance_fund_rate"]').bind('input propertychange', function() {
        var maintenance_fund_rate = $(this).val();
        var area = $('input[name="area"]').val();
        if (area == '') {
            $('#tip_maintenance').html('建筑面积没有填写');
        } else {
            $('#tip_maintenance').html('');
            var maintenance_fund = maintenance_fund_rate * area;
            $('input[name="maintenance_fund"]').val(isNaN(maintenance_fund) ? 0 : maintenance_fund.toFixed(2));
        }
    });


    /**
     * 填写价格调节基金利率的时候触发
     */
    $('input[name="price_regulation_fund_rate"]').bind('input propertychange', function() {
        var total_price_now = $('input[name="total_price_now"]').val();
        var price_regulation_fund_rate = $(this).val();
        if (total_price_now == '') {
            $('#tip_regulation').html('成交总价没有填写');
        } else {
            $('#tip_regulation').html('');
            var price_regulation_fund = total_price_now * price_regulation_fund_rate / 100;
            $('input[name="price_regulation_fund"]').val(isNaN(price_regulation_fund) ? 0 : price_regulation_fund.toFixed(2));
        }
    });

    function monthInterest(value) {
        document.getElementById('month_interest').innerHTML = value;
    }

    function monthPrincipal(value) {
        document.getElementById('month_principal').innerHTML = value;
    }

    function ac_monthSip(value) {
        document.getElementById('ac_month_sip').innerHTML = value;
    }

    function ac_monthInterest(value) {
        document.getElementById('ac_month_interest').innerHTML = value;
    }



    /**
     * 计算银行按揭
     * @param  {[type]} $msg [description]
     * @return {[type]}      [description]
     */
    function calculate_total($msg) {
        var calcdivate_type = $('input[name="calcdivate_type"]').val();

        var $month = parseInt($msg['year']) * 12; //还款月数
        var $rate = $msg['rate'] / 100; //年利率
        var $month_rate = $rate / 12; //月利率
        var $credit = parseInt($msg['credit']); //贷款总额
        $data = new Array(); //要返回的数据 $data[1] 等额本息 $data[2]等额本金
        /*计算每月月供额   月还款额=贷款总额*月利率*(1+月利率)^n/[(1+月利率)^n-1] (n 贷款月数)*/
        $aa = (1 + $month_rate); //(1+月利率)
        $a = Math.pow($aa, $month); //[(1+月利率)^n]
        $b = $a - 1; //[(1+月利率)^n-1]
        $c = $a * $credit; //贷款总额*月利率
        $d = $c * $month_rate; //*(1+月利率)^n
        $month_sip = $d / $b; //每月月供额
        $data[1] = new Array();
        $data[2] = new Array();
        $data[1]['credit'] = $credit;
        $data[1]['month_sip'] = $month_sip.toFixed(2);


        /*计算每月应还利息  每月应还利息=贷款剩余款数x月利率       如：（200000×4.2%/12）*/
        $credit_1 = $credit; //贷款总额 （方便操作）
        $interest_total = 0; //利息总和
        $data[1]['month_principal'] = new Array();
        $data[1]['month_interest'] = new Array();
        for (var $i = 1; $i <= $month; $i++) {
            $g = $credit_1 * $month_rate; //每月利息
            $month_p = $month_sip - $g; //每月本金
            $credit_1 = $credit_1 - $month_p; //剩余贷款
            $data[1]['month_principal'][$i] = $month_p.toFixed(2); //将每个月的本金存入
            $data[1]['month_interest'][$i] = $g.toFixed(2); //将每个月的利息存入
            $interest_total = $interest_total + $g; //利息总和
        }
        /*计算总利息 总利息=n×每月月供额-贷款本金*/
        $interest = $month * $month_sip - $credit; //$interest 与 $interest_total 几乎相等。
        $data[1]['interest_total'] = $interest_total.toFixed(2); //总利息
        $repayment = $interest_total + $credit;
        $data[1]['repayment'] = $repayment.toFixed(2); //还款总额



        $data[2]['credit'] = $credit;
        $ac_month_capital = $credit / $month; //每月还款本金 （本金/还款月数）
        $data[2]['ac_month_capital'] = $ac_month_capital.toFixed(2);
        $credit_1 = $credit;
        $ac_interest_total = 0; //总利息
        $data[2]['month_interest'] = new Array();
        $data[2]['month_sip'] = new Array();
        for (var $i = 1; $i <= $month; $i++) {
            $credit_1 = $credit_1 - $ac_month_capital;
            $g = $credit_1 * $month_rate;
            $ac_month_sip = $ac_month_capital + $g;
            $data[2]['month_interest'][$i] = $g.toFixed(2); //月利息
            $data[2]['month_sip'][$i] = $ac_month_sip.toFixed(2); //月还款
            $ac_interest_total = $ac_interest_total + $g;
        }
        $data[2]['interest_total'] = $ac_interest_total.toFixed(2);
        $ac_repayment = $ac_interest_total + $credit;
        $data[2]['repayment'] = $ac_repayment.toFixed(2); //还款总额
        calculate_date = $data;
        showhtml($data);
    }




    /**
     * 显示银行按揭结果
     * @param  {[type]} data [description]
     * @return {[type]}      [description]
     */
    function showhtml(data) {
        var calcdivate_type = $('input[name="calcdivate_type"]:checked').val();
        var data1 = data[1];
        var data2 = data[2];
        var month_interest1 = '';
        var month_principal1 = '';
        var month_sip2 = '';
        var month_interest2 = '';
        var k = 0;
        for (var j in data1['month_interest']) { k++ };
        for (var i = 1; i <= k; i++) {
            month_interest1 += '<option value="' + data1['month_interest'][i] + '">' + i + '月</option>';
            month_principal1 += '<option value="' + data1['month_principal'][i] + '">' + i + '月</option>';
            month_sip2 += '<option value="' + data2['month_sip'][i] + '">' + i + '月</option>';
            month_interest2 += '<option value="' + data2['month_interest'][i] + '">' + i + '月</option>';
        }
        var html = '';
        switch (parseInt(calcdivate_type)) {
            case 1:
                html += '<table style="margin: 1px">'+
                            '<tr><td><h3 style="font-size: 25px;">等额本息</h3></td></tr>'+
                            '<tr><td><h5>贷款总额：</h5><span style="background-color:#9d9d9d">' + data1.credit + '</span>元</td></tr>'+
                            '<tr><td><h5>月均还款：</h5><span style="background-color:#9d9d9d">' + data1.month_sip + '</span>元</td></tr>'+
                            '<tr><td><h5>每月利息：</h5><select onchange="monthInterest(this.value)">' + month_interest1 + '</select><span id="month_interest" style="margin-left:5px;background-color:#9d9d9d">' + data1.month_interest[1] + '</span>元</td></tr>'+
                            '<tr><td>全部利息：</h5><span id="interest_total" style="background-color:#9d9d9d">' + data1.interest_total + '</span>元</td></tr>'+
                            '<tr><td>每月本金：</h5><select onchange="monthPrincipal(this.value)">' + month_principal1 + '</select><span id="month_principal" style="margin-left:5px;background-color:#9d9d9d">' + data1.month_principal[1] + '</span>元</td></tr>'+
                            '<tr><td>还款总额：</h5><span style="background-color:#9d9d9d">' + data1.repayment + '</span>元</td></tr>'+
                            '<input type="hidden" name="month_sip_1" value="' + data1.month_sip + '" >'+
                            '<input type="hidden" name="interest_total_1" value="' + data1.interest_total + '" >'+
                        '</table>';
                break;
            case 2:
                html += '<table style="margin: 1px;">'+
                            '<tr><td><h3 style="font-size: 25px;">等额本金</h3></td></tr>'+
                            '<tr><td><h5>贷款总额：</h5><span style="background-color:#9d9d9d">' + data2.credit + '</span>元</td></tr>'+
                            '<tr><td><h5>每月还款：</h5><select onchange="ac_monthSip(this.value)">' + month_sip2 + '</select><span id="ac_month_sip" style="margin-left:5px;background-color:#9d9d9d">' + data2.month_sip[1] + '</span>元</td></tr>'+
                            '<tr><td><h5>每月利息：</h5><select onchange="ac_monthInterest(this.value)">' + month_interest2 + '</select><span id="ac_month_interest" style="margin-left:5px;background-color:#9d9d9d">' + data2.month_interest[1] + '</span>元</td></tr>'+
                            '<tr><td><h5>全部利息：</h5><span id="interest_total" style="background-color:#9d9d9d">' + data2.interest_total + '</span>元</td></tr>'+
                            '<tr><td><h5>月均本金：</h5><span style="background-color:#9d9d9d">' + data2.ac_month_capital + '</span>元</td></tr>'+
                            '<tr><td><h5>还款总额：</h5><span style="background-color:#9d9d9d">' + data2.repayment + '</span>元</td></tr>'+
                            '<input type="hidden"  name="ac_month_capital" value="' + data2.ac_month_capital + '" >'+
                            '<input type="hidden" name="interest_total_2" value="' + data2.interest_total + '" >'+
                        '</table>';
                break;
            case 3:
                html += '<table style="margin: 1px">'+
                            '<tr><td><h3 style="font-size: 25px;">等额本息</h3></td></tr>'+
                            '<tr><td><h5>贷款总额：</h5><span style="background-color:#9d9d9d">' + data1.credit + '</span>元</td></tr>'+
                            '<tr><td><h5>月均还款：</h5><span style="background-color:#9d9d9d">' + data1.month_sip + '</span>元</td></tr>'+
                            '<tr><td><h5>每月利息：</h5><select onchange="monthInterest(this.value)">' + month_interest1 + '</select><span id="month_interest" style="margin-left:5px;background-color:#9d9d9d">' + data1.month_interest[1] + '</span>元</td></tr>'+
                            '<tr><td>全部利息：</h5><span id="interest_total" style="background-color:#9d9d9d">' + data1.interest_total + '</span>元</td></tr>'+
                            '<tr><td>每月本金：</h5><select onchange="monthPrincipal(this.value)">' + month_principal1 + '</select><span id="month_principal" style="margin-left:5px;background-color:#9d9d9d">' + data1.month_principal[1] + '</span>元</td></tr>'+
                            '<tr><td>还款总额：</h5><span style="background-color:#9d9d9d">' + data1.repayment + '</span>元</td></tr>'+
                            '<input type="hidden" name="month_sip_1" value="' + data1.month_sip + '" >'+
                            '<input type="hidden" name="interest_total_1" value="' + data1.interest_total + '" >'+
                        '</table>';

                html += '<table style="margin: 1px;">'+
                            '<tr><td><h3 style="font-size: 25px;">等额本金</h3></td></tr>'+
                            '<tr><td><h5>贷款总额：</h5><span style="background-color:#9d9d9d">' + data2.credit + '</span>元</td></tr>'+
                            '<tr><td><h5>每月还款：</h5><select onchange="ac_monthSip(this.value)">' + month_sip2 + '</select><span id="ac_month_sip" style="margin-left:5px;background-color:#9d9d9d">' + data2.month_sip[1] + '</span>元</td></tr>'+
                            '<tr><td><h5>每月利息：</h5><select onchange="ac_monthInterest(this.value)">' + month_interest2 + '</select><span id="ac_month_interest" style="margin-left:5px;background-color:#9d9d9d">' + data2.month_interest[1] + '</span>元</td></tr>'+
                            '<tr><td><h5>全部利息：</h5><span id="interest_total" style="background-color:#9d9d9d">' + data2.interest_total + '</span>元</td></tr>'+
                            '<tr><td><h5>月均本金：</h5><span style="background-color:#9d9d9d">' + data2.ac_month_capital + '</span>元</td></tr>'+
                            '<tr><td><h5>还款总额：</h5><span style="background-color:#9d9d9d">' + data2.repayment + '</span>元</td></tr>'+
                            '<input type="hidden"  name="ac_month_capital" value="' + data2.ac_month_capital + '" >'+
                            '<input type="hidden" name="interest_total_2" value="' + data2.interest_total + '" >'+
                        '</table>';
                break;
        }
        $('#calculate_res').html(html);
    }

