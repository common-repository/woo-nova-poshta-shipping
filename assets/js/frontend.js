(function ($) {

    let CitySender = {
        "ref": "0"
    };
    let CityRecipient = {
        "ref": "0"
    };
    let weight = ($("#weight").text() != '0') ? $("#weight").text() : '0.3';
    let Cost = {
        "cost": "0"
    };
    let serviceType = {
        "type" : "DoorsDoors"
    }
    let cargoType = $("#cargotype").val();

    $("#wnps_area").select2({
        placeholder: "Оберіть область",
        allowClear:true
    });
    
    $("#wnps_city").select2({
        placeholder: "Оберіть місто",
        allowClear:true
    });

    $("#wnps_warehouse").select2({
        placeholder: "Оберіть відділення",
        allowClear:true
    });
    
    $("#wnps_shippingtype").select2({
        placeholder: "Оберіть тип доставки",
        allowClear:true
    });


    $('#wnps_area').change(function(){
        $(this).find(':selected').attr('data-selected','selected-area')
            .siblings('option').removeAttr('data-selected');
    });
    $('#wnps_city').change(function(){
        $(this).find(':selected').attr('data-selected','selected-city')
            .siblings('option').removeAttr('data-selected');
    });
    $('#wnps_warehouse').change(function(){
        $(this).find(':selected').attr('data-selected','selected-warehouse')
            .siblings('option').removeAttr('data-selected');
    });

    $.ajax({
        type: "GET",
        data: "action=wnps_get_areas",
        url: ajaxurl.url,
        success: function (resp) {
            var resp = JSON.parse(resp);
            render_options('.wnps_area', resp);
        },
        error: function (resp) {
        }
    });

    $.ajax({
        type: "GET",
        data: "action=wnps_get_city_sender",
        url: ajaxurl.url,
        success: function (resp) {
            hundleSender(resp, CitySender);
        },
        error: function (resp) {
            console.log("error");
        }
    })

    $.ajax({
        type: "GET",
        data: "action=wnps_get_total_goods_price",
        url: ajaxurl.url,
        success: function(resp){
            hundleCost(resp, Cost);
        },
        error: function(resp){
            console.log("error");
        }
    })

    $('.wnps_area').on('change', function () {
        var selected = $(".wnps_area option:selected").val();
        $.ajax({
            type: "GET",
            data: "area=" + selected + "&action=wnps_get_cities",
            url: ajaxurl.url,
            success: function (resp) {
                var resp = JSON.parse(resp);

               render_options_cities('.wnps_city', resp);

            },
            error: function (resp) {
                console.log("error");
            }
        })
    });

    $('.wnps_city').on('change', function () {
        var selected = $(".wnps_city option:selected").text();
        
        $.ajax({
            type: "GET",
            data: "city=" + selected + "&action=wnps_get_warehouses",
            url: ajaxurl.url,
            success: function (resp) {
                var resp = JSON.parse(resp);
                render_options_warehouses('.wnps_warehouse', resp);
            },
            error: function (resp) {
                console.log("error");
            }
        })

        $.ajax({
            type: "GET",
            data: "city=" + selected + "&action=wnps_get_city_recepient",
            url: ajaxurl.url,
            success: function (resp) {
                var resp = JSON.parse(resp);
                console.log(resp);
                hundleRecipientRequest(resp, CityRecipient);
            },
            error: function (resp) {
                console.log("error");
            }
        })

    });

    $('.wnps_shippingtype').on('change', function(){
        var selected = $(".wnps_shippingtype option:selected").val();
        hundleServiceType(selected, serviceType);
    })

    function hundleCost(data, totalCost){
        totalCost['cost'] = data;
    }

    function hundleSender(data, citySend){
        citySend["ref"] = data;
    }

    function hundleRecipientRequest(data, cityRec){
        cityRec["ref"] = data;
    }

    function hundleServiceType(data, servType){
        servType["type"] = data;
    }

    /**
     * Empty parent block
     *
     * @param {string} parent_block
     * @param {string} child_block
     */
    function empty_parent(parent_block = '', child_block = '') {
        if ($(parent_block).has(child_block)) {
            $(parent_block).empty();
        }
    }

    function render_options(selector, data) {
        var options = data;
        var options_count = Object.keys(data).length;
        var content = "<option value='0' selected='selected'>Выберите область</option>"
        render_content(selector, content);
        for(var i = 0; i < options_count; i++){
            var content = "<option value='" + options[i].Ref + "' title='" + options[i].Description + "'>"+ options[i].Description +"</option>"
            render_content(selector, content);
        }
    }

    function render_options_cities(selector, data) {
        empty_parent(selector, "option");
        var options = data;
        var options_count = Object.keys(data).length;
        var content = "<option value='0' selected='selected'>Выберите город</option>"
        render_content(selector, content);
        for(var i = 0; i < options_count; i++){
            var content = "<option value='" + options[i].Ref + "'>"+ options[i].Description +"</option>"
            render_content(selector, content);
        }
    }

    function render_options_warehouses(selector, data) {
        empty_parent(selector, "option");
        var options = data;
        var options_count = Object.keys(data).length;

        var weight_lim = document.getElementById("total_int").textContent;
        var num = parseFloat(weight_lim);

        let arr;

        if ( num <= 30 ||  options_count < 3 ) {
            arr = options.filter(word => word.PlaceMaxWeightAllowed);
        } else {
            arr = options.filter(word => word.PlaceMaxWeightAllowed > 30);
        }
        var content = "<option value='0' selected='selected'>Выберите отделение</option>"
        render_content(selector, content);
        content = '';
        
        for (var i = 0; i < arr.length; i++) {
            content += "<option value='" + arr[i].Ref + "'>" + arr[i].Description + "</option>"
        }

        render_content(selector, content);
    }

    /**
     * Render html content with appending to parent element
     *
     * @param {string} append_to
     * @param {string} contentt
     */
    function render_content(append_to = '', content = '') {
        $(append_to).append(content);
    }

    /* promises */

    $("#wnps_shippingtype").on("change", function(){        
        getNP();
    })


    function getCityRecipient(){
        var selected = $(".wnps_city option:selected").text();
        var result;
        $.ajax({
            type: "GET",
            data: "city=" + selected + "&action=wnps_get_city_recipient",
            url: ajaxurl.url,
            success: function (resp) {
                result = resp;
            },
            error: function (resp) {
                console.log("error");
            }
        });
        return result;
    }

    const getNP = () => {
        let body = {
            "modelName": "InternetDocument",
            "calledMethod": "getDocumentPrice",
            "methodProperties": {
            "CitySender": CitySender.ref,
            "CityRecipient": CityRecipient.ref,
            "Weight": weight,
            "ServiceType": serviceType.type,
            "Cost": Cost.cost,
            "CargoType": cargoType,
            "SeatsAmount": "1"
                
            },
            "apiKey": "264fb844abef16e84663f922267df5fd"
        };

        return fetch("https://api.novaposhta.ua/v2.0/json/", {
            method: "POST",
            headers: {
                'Content-Type' : 'application/json;charset=utf-8'
            },
            body: JSON.stringify(body)
        })
        .then(
            response => response.json()
        )
        .then(
            responseData => sendSippingPrice(responseData.data[0])
        )
        .catch(
            error => console.warn(error)
        )
    }

    function sendSippingPrice(shippingPrice){
        var shipping_method = $("#shipping_method_0_nova_poshta_shipping").val();

        $.ajax({
            type: "POST",
            data: "cost=" + shippingPrice.Cost + "&shipping_method=" + shipping_method +"&action=wnps_change_shipping_cost",
            url: ajaxurl.url,
            success: function (resp) {
                $('body').trigger('update_checkout');
                console.log(resp);
            },
            error: function (resp) {
                console.error('Error');
            }
        })
    }
 
})(jQuery)