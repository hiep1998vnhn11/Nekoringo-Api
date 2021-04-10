var list = [];
$("#main_container fieldset table table tbody tr td:last-child").each(
    function() {
        var dResult = $(this)
            .find(".d_result")
            .text()
            .replace(/\s+/g, " ");
        var divString = $(this)
            .find("div")
            .last()
            .text()
            .replace(/\n/g, "")
            .replace(/\s+/g, " ");
        var tel, fax, address, notes = null;
        if (dResult.lastIndexOf("Address:") != -1) {
            notes = dResult
                .substring(0, dResult.lastIndexOf("Address:"))
                .trim();
        } else {
            notes = dResult.trim();
        }
        if (
            divString.lastIndexOf("Tel:") != -1 &&
            divString.lastIndexOf("Fax:") != -1
        ) {
            tel = divString
                .substring(
                    divString.lastIndexOf("Tel:") + 5,
                    divString.lastIndexOf("Fax:") - 2
                )
                .replace(/\s/g, "");
            fax = divString
                .substring(divString.lastIndexOf("Fax:") + 5, divString.length)
                .replace(/\s/g, "");
            address = divString
                .substring(
                    divString.lastIndexOf("Address:") + 9,
                    divString.lastIndexOf("Tel:")
                )
                .replace(/\s+/g, " ")
                .trim();
        }
        if (
            divString.lastIndexOf("Tel:") != -1 &&
            divString.lastIndexOf("Fax:") == -1
        ) {
            tel = divString
                .substring(divString.lastIndexOf("Tel:") + 5, divString.length)
                .replace(/\s/g, "");
            fax = null;
            address = divString
                .substring(
                    divString.lastIndexOf("Address:") + 9,
                    divString.lastIndexOf("Tel:")
                )
                .replace(/\s+/g, " ")
                .trim();
        }
        if (
            divString.lastIndexOf("Tel:") == -1 &&
            divString.lastIndexOf("Fax:") != -1
        ) {
            tel = null;
            fax = divString
                .substring(divString.lastIndexOf("Fax:") + 5, divString.length)
                .replace(/\s/g, "");
            address = divString
                .substring(
                    divString.lastIndexOf("Address:") + 9,
                    divString.lastIndexOf("Fax:")
                )
                .replace(/\s+/g, " ")
                .trim();
        }
        if (
            divString.lastIndexOf("Tel:") == -1 &&
            divString.lastIndexOf("Fax:") == -1
        ) {
            tel = fax = null;
            address = divString
                .substring(
                    divString.lastIndexOf("Address:") + 9,
                    divString.length
                )
                .replace(/\s+/g, " ")
                .trim();
        }

        list.push({
            school_name: $(this)
                .find("span")
                .first()
                .text()
                .trim(),
            notes,
            address,
            tel,
            fax
        });
    }
);

var formRequest = new FormData();
formRequest.append("data", JSON.stringify(list));
$.ajax({
    url: "http://localhost:8000/api/make_database",
    headers: {
        Accept: "application/json",
        "Access-Control-Allow-Origin": "*"
    },
    type: "POST",
    data: formRequest,
    processData: false,
    contentType: false,
    success: function(data) {}
});


var formRequest = new FormData();
formRequest.append("data", JSON.stringify(list));
$.ajax({
    url: "http://localhost/edapt_subversion/extract-school/create-database",
    type: "POST",
    success: function(response) {
        console.log(response);
    },
    error(hr, ex) {
        console.log(hr, ex);
    },
    data: formRequest,
    crossDomain: true,
    cache: false,
    processData: false,
    headers: {
        Accept: "application/json",
        "Access-Control-Allow-Origin": "*"
    }
});

$.ajax({
    url: "http://localhost/edapt_subversion/extract-school/create-database",
    type: "POST",
    success: function(response) {
        console.log(response);
    },
    error(hr, ex) {
        console.log(hr, ex);
    },
    data: JSON.stringify(list),
    crossDomain: true,
    cache: false
});