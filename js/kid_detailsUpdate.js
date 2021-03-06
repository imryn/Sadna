function DetailskidUpdate(){
    var data = getFormData("#kid-observation");
    var kidData = getFormData("#kidList-detailsUpdate");
    data["kidId"] = kidData['kidId'];
    data["fname"] = kidData['fname'];
    data["lastname"] = kidData['lastname'];
    var date = new Date(data.observationDate).getTime();
    // var checkdate = isValidDate(date ,DetailskidUpdate);

    // if(!checkdate){
    //     return;
    // }

    if(!isNaN(date)){
        data.observationDate = date;
    }
    data['route'] = 'observation_error';
    httpPost("/Sadna/server/api.php",data,function(response){
        if(response.success){
            DetailskidUpdate.error("Observation was added successfully !!")
        }
       
    })

}

DetailskidUpdate.error= function(msg){
    document.querySelector(".success-message").textContent = msg;
}


savingChangesinKidbag.error=function(msg){
    document.querySelector(".success-message2").textContent = msg;
}

// function isValidDate(datecheck,errorFunction) {
//     var status = false;
//     console.log(datecheck);
//     if (!datecheck || datecheck.length <= 0) {
//       status = false;
//     } else {
//       var result = new Date(datecheck);
//       if (result == 'Invalid Date') {
//         status = false;
//         errorFunction.error("You can't put new observation without choosing A date");

//       } else {
//         status = true;
//       }
//     }
//     return status;
//   }


$(document).ready(function(){
    $("#new-observation").click(function(){
        $("#kid-observation").fadeToggle(2000);
        
    });
});


function savingChangesinKidbag(){
    var KiData = getFormData("#kid-detailsUpdate");
    var date = new Date(KiData.bDate).getTime();
    if(!isNaN(date)){
        KiData.bDate = date;
    }

    KiData['route'] = 'update_kid';
    httpPost("/Sadna/server/api.php",KiData,function(response){
        if(response.success){
            savingChangesinKidbag.error("Child file was updated successfully !!");
        }

    })
}

function showKindergartenkid(){
    httpGet("/Sadna/server/api.php?route=getKindergartenkid",{}, function(response){
        if(response.success){
            kinderGarten = response.data;
            var flatData = response.data.map(function(item){
                return item.fname + " " + item.lastname;                
            })

           putInfoInsideSelector("#kid-choosen #kidname" ,flatData);
        }
    });

    $("input, select, option, textarea", "#kidList-detailsUpdate").prop('disabled',true);
}

function showInfoAboutakid(){
    httpGet("/Sadna/server/api.php?route=getKidInfo",{}, function(response){
        if(response.success){
            response.data.bDate = timestampToDate(response.data.bDate);

            setFormData("#kid-detailsUpdate form",response.data);
        }
    });
}

var kinderGarten;


function showInfoAboutakidList(){
    var data = getFormData("#kid-choosen");

    var selectedKid = kinderGarten[data.kidOptions];
    data.kidFname = selectedKid.fname;
    data.kidLname = selectedKid.lastname;
    
    $('#new-observation').prop('disabled', false);
        
    httpGet("/Sadna/server/api.php?route=getKidListInfo",data, function(response){
        if(response.success){
            console.log(response.data);
            response.data.bDate = timestampToDate(response.data.bDate);

            setFormData("#kidList-detailsUpdate form",response.data);
        }
    });

} 