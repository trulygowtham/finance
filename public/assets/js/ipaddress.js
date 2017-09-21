$.getJSON("http://jsonip.com?callback=?", function (response) {
    var path = document.URL;
	 
    var baseUrl = document.location.origin;

    var ip = response.ip;
    var url = "http://locahost/analytics/ip/saveIp";
    $.ajax({
        url: url,
        type: "post",
        data: {ip: ip, path: path, project: baseUrl},
        success: function (response) {
            // you will get response from your php page (what you echo or print) 
            //alert(response);		   

        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(textStatus, errorThrown);
        }


    });
});