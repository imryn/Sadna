function getReports(){
    var data = getFormData("#reports form");

    $.get("reports/" + data.optionsReport + ".html",function(response){
        document.querySelector(".report-data-container").innerHTML = response;
        console.log(data);
        
        showKindergartenkid();

    })

}

function getAlergicReports(){
    var data = getFormData("#alergic-report form");
    httpGet("/Sadna/server/api.php?route=get_Alergicreport", data,function(response){
        if(response.success && response.data instanceof Array){
            if(response.data.length){
                createAlergicTable(response.data);
                getAlergicReports.error("");
             }
            
             else{
                document.getElementById('kids-table').innerHTML = "";
                getAlergicReports.error("No alergic was recorded on selected");
              }
           }
        });
    }

    getAlergicReports.error = function (msg){
        document.querySelector(".unsuccess-message").textContent = msg;
    }

    getExceptionReports.error=function(msg){
        document.querySelector(".unsuccess-message").textContent = msg;
    }
 

function getPresenceReport(){
        var data = getFormData("#exception-report form");
        var selectedKid = kinderGarten[data.nopresenceoptions];
        var startDate = data.startDate//new Date(data.startDate).getTime();       
        var endDate = data.endDate//new Date(data.endDate).getTime();
     
        data.fname = $("#exception option:selected").text().split(' ')[0]
        if(data.fname && data.fname!='All'){
            data.lastname = $("#exception option:selected").text().split(' ')[1]
        }
        httpGet("../Sadna/server/api.php?route=get_Presencereport", data,function(response){
            if(response.success && response.data instanceof Array){
                if(response.data){
                    createPresenceTable(response.data);
                    getPresenceReport.error("");
                }
                else{
                    getPresenceReport.error("No attendance was recorded on selected date range");
                }
            }
            
        });
    }
    

function getExceptionReports(data){
    var selectedKid = kinderGarten[data.exceptionOptions];
    data.kidFname = selectedKid.fname;
    data.kidLname = selectedKid.lastname;

    var startDate = new Date(data.startDate).getTime();
    if(!isNaN(startDate)){
        data.startDate = startDate;
    }
    else{
        return
    }
    var endDate = new Date(data.endDate).getTime();
    if(!isNaN(endDate)){
        data.endDate = endDate;
    }
    else{
        return;
    }
    
    httpGet("/Sadna/server/api.php?route=get_Exceptionsreport", data,function(response){
        if(response.success && response.data instanceof Array){
            if(response.data.length){
                response.data.forEach(function(item){
                    item.date = timestampToDate(item.date);
                })
                createExceptionTable(response.data);
                getExceptionReports.error("");
            }
            else{
                document.getElementById('kids-observation-table').innerHTML = "";
                getExceptionReports.error("No comments for selected date");
            }
        }
        
    });
}

function genrateKidReport(){
    var data = getFormData("#exception-report form");
    if(loginType() && data.exceptionOptions == 0){
        getExceptionGraph(data);
        document.getElementById('kids-observation-table').innerHTML = "";
    }
    else{
        document.getElementById('chart_div').innerHTML = "";
        getExceptionReports(data);
    }
}

function getExceptionGraph(data){   
    var selectedKid = kinderGarten[data.exceptionOptions];
    data.kidFname = selectedKid.fname;
    data.kidLname = selectedKid.lastname;

    var startDate = new Date(data.startDate).getTime();
    if(!isNaN(startDate)){
        data.startDate = startDate;
    }
    else{
        return
    }
    var endDate = new Date(data.endDate).getTime();
    if(!isNaN(endDate)){
        data.endDate = endDate;
    }
    else{
        return;
    }
    
    httpGet("/Sadna/server/api.php?route=get_Exceptionsgraph", data,function(response){
        if(response.success && response.data instanceof Array){
            if(response.data.length){
                response.data.forEach(function(item){
                    item.date = timestampToDate(item.date);
                })
                    var namesData = {};
                    response.data.forEach(function(row){
                        var key = row.first_name + " " + row.last_name;
                        namesData[key] = namesData[key] || [];
                        namesData[key].push(row);
                    })
                    var chartData = Object.keys(namesData).map(function(name){
                        return [name,namesData[name].length];
                    })
                    console.log(chartData)
                    drawChart(chartData);
                
                getExceptionReports.error("");
            }
            else{
                document.getElementById('chart_div').innerHTML = "";
                getExceptionReports.error("No comments for selected date");
            }
        }
        
    });
}

var kinderGarten;

function loginType(){
    var cookie = document.cookie.match("(loginType=)(.*)");
    return (cookie && cookie[2] && cookie[2] == 'crew' ? true : false);
}

function showKindergartenkid(){
    httpGet("/Sadna/server/api.php?route=getKindergartenkid",function(response){
        if(response.success){
            kinderGarten = response.data;
            if(loginType()){
                response.data.unshift({fname:"All",lastname:""});
            }
            var flatData = response.data.map(function(item){
                return item.fname + " " + item.lastname;
            })
            putInfoInsideSelector("#exception-report #exception" ,flatData);
        }
    });
}

function buildThs(array){
    var row = '<tr>'
    array.forEach(function(item){
        row = row +'<th scope="row">'+item+'</th>';
    })
    return row + '</tr>';
}//



function createAlergicTable(data){
    var tableElement = document.getElementById("kids-table");
    var table='';

    table = table + buildThs(['First Name','Last Name','Parent Name','Phone Number']);

    data.forEach(function(item) {
        table = table + '<tr class="table-info"><td>'+item.first_name+'</td><td>' +item.last_name+'</td><td>'+item.parent_name +'</td><td>' + item.phone_number +'</td></tr>';
    });
    tableElement.innerHTML = table;
    console.log(table)
}

function createExceptionTable(data){
    var tableElement = document.getElementById("kids-observation-table");
    var table='';

    table = table + buildThs(['Date','Name','Observation', 'Special Requests']);

    data.forEach(function(item) {
        table = table + '<tr class="table-info"><td>' + item.date + '</td><td>' + item.last_name + " " + item.first_name+ '</td><td>' +item.note +'</td><td>' + item.specialReq + '</td></tr>';
    });
    tableElement.innerHTML = table;
    console.log(table)
}

function createPresenceTable(data){
    var tableElement = document.getElementById("kids-presence-table");
    var table='';

    table = table + buildThs(['Date','First Name','Last Name']);

    data.forEach(function(item) {
        table = table + '<tr class="table-info"><td>'+item.date+'</td><td>'+item.fname+'</td><td>' +item.lastname+'</td></tr>';
    });
    tableElement.innerHTML = table;
}