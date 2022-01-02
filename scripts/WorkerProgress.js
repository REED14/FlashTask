window.onload = function(){
    var icondiv = document.getElementById("icons");
    var bardiv = document.getElementById("progress-bar");
    var statusname = document.getElementById("status");
    var divmap = document.getElementById("map");
    var cancelBtn = document.getElementById("cancelBttn");
    var idfk = document.getElementById("idfk");
    var divform = document.getElementById("fdiv");
    var body = document.body;
    var head = document.head;

    var chore_state=1;
    var worker_lat=0;
    var worker_lng=0;

    if(navigator.geolocation)
    {
        navigator.geolocation.getCurrentPosition(fetch_data, noFetch);
        setInterval(function(){
            navigator.geolocation.getCurrentPosition(fetch_data, noFetch);
        }, 5000);
    }
    
    function fetch_data(position){

        var PosX=position.coords.latitude;
        var PosY=position.coords.longitude;

        $.ajax({
            url:"./server-scripts/wload_cstate.php",
            method: "POST",
            dataType: 'json',
            data : {"workerPosX": PosX, "workerPosY": PosY},
            success : function(data){
                //console.log(result['wLat']);
                chore_state = data['choreStatus'];
                console.log(data);

                

                switch(chore_state){
                    case "0":
                        icondiv.innerHTML = '<img src="logoForProgress/SearchSign.svg" alt="searchSign" id="searchSign">';
                        divmap.style.display = "none";
                        icondiv.style.marginBottom = "100px";
                        bardiv.innerHTML = '<div class="in-progress"><div class="percent"></div></div><div class="unstarted"> </div> <div class="unstarted"> </div>';
                        statusname.innerHTML =  "<a>Press start to do this chore</a>";
                        break;
                    case "1":
                        icondiv.innerHTML = ' <div id="motorcycle"> <svg version="1.1" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 500 500" style="enable-background:new 0 0 500 500;" xml:space="preserve"> <style type="text/css"> .st0{fill:#009444;} .st1{opacity:0.57;fill:#AAD69B;} .st2{opacity:0.39;fill:#AAD69B;} .st3{opacity:0.63;fill:#AAD69B;} .st4{opacity:0.47;fill:#AAD69B;} #FrontWheel{ transform-origin: center; transform-box: fill-box; } </style> <g id="FrontWheel"> <g> <path class="st0" d="M411.4,219.1c-37.8,0-68.5,30.7-68.5,68.5c0,37.8,30.7,68.5,68.5,68.5c37.8,0,68.5-30.7,68.5-68.5 C480,249.8,449.3,219.1,411.4,219.1z M411.4,342.4c-30.3,0-54.8-24.5-54.8-54.8c0-30.3,24.5-54.8,54.8-54.8s54.8,24.5,54.8,54.8 C466.3,317.9,441.7,342.4,411.4,342.4z"/> <path class="st0" d="M411.3,287.4c23.4-23.4,14.1-48.9,22.9-54.6c10.7-6.9,43.4,45.6,31.9,50C453.7,287.6,439,288.6,411.3,287.4z" /> <path class="st0" d="M413,285.9c-0.6,33,23.9,43.5,21.5,53.7c-2.9,12.4-62.9,1.4-57.7-9.8C384.2,313.8,387.7,308.2,413,285.9z"/> <path class="st0" d="M413.1,288.7c-25.7-20.8-49.9,4.1-56.5-4c-8-9.9,19.1-53.4,27.8-44.6C396.3,251.9,399.1,255.8,413.1,288.7z" /> </g> </g> <g id="BackWheel"> <g> <path class="st0" d="M92.6,219.3c-37.8,0-68.5,30.7-68.5,68.5c0,37.8,30.7,68.5,68.5,68.5c37.8,0,68.5-30.7,68.5-68.5 C161.1,250,130.4,219.3,92.6,219.3z M92.6,342.7c-30.3,0-54.8-24.5-54.8-54.8c0-30.3,24.5-54.8,54.8-54.8s54.8,24.5,54.8,54.8 C147.4,318.1,122.9,342.7,92.6,342.7z"/> <path class="st0" d="M92.4,287.6c23.4-23.4,14.1-48.9,22.9-54.6c10.7-6.9,43.4,45.6,31.9,50C134.8,287.9,120.1,288.9,92.4,287.6z" /> <path class="st0" d="M94.2,286.2c-0.6,33,23.9,43.5,21.5,53.7c-2.9,12.4-62.9,1.4-57.7-9.8C65.4,314,68.8,308.5,94.2,286.2z"/> <path class="st0" d="M94.3,289c-25.7-20.8-49.9,4.1-56.5-4c-8-9.9,19.1-53.4,27.8-44.6C77.4,252.2,80.2,256,94.3,289z"/> </g> </g> <g id="MotorBody"> <path class="st0" d="M161,193.9c-19-19.2-37.7-14-75.8-26.8c-33.1-11.2-62.9-30-61.1-35.3c0.8-2.3,7.2-0.7,25.3,0 c43.2,1.8,58-5.1,73.2,6.8c4.8,3.8,3.3,4.4,9.7,9.7c5.8,4.7,19.7,16.3,39.2,16.1c3,0,25.6,0.6,32.6-12.1c1.8-3.2,1.3-5,2.1-7.9 c4.8-17.8,41.8-26.1,68.9-25.8c13.5,0.2,41.8,0.5,51.1,16.8c2.8,4.9,2.6,9.1,6.3,10.5c4.4,1.7,10.3-2.3,32.6-24.2 c12.2-12,11.8-15,15.8-15.8c17.5-3.6,42.6,63.7,42.6,63.7s-38.3,31.3-36.1,36.1c0.9,1.8,5.2-0.2,17.1,0c15.5,0.3,24.5-0.2,33.3,3.1 c10,3.8,10,3.8,10.4,5.6c0.4,2-3.7,5.8-5.3,5.3c-17.9-5.8-38.4-13.9-70,0l-17.9-23.9c0,0-26,1-43.3,2.9c-9,1-25.7,7.4-34.1,11.8 c-23,12.2-23,12.2-41.6,21.7c-2.4,1.2,7.9,19.5,1.6,25.4c-4.7,4.4-7.4,24.7-7.4,24.7s-15.2-1.3-20,0c-5.2,1.4-20,5.4-20,5.4 s3.5-10.8,0-14.3c-3.8-3.8-14.8,5.2-27.9,7.9c-25.4,5.3-54-14-52.6-22.6c1.1-6.8,20.8-5.8,51.6-23.7c5.7-3.3,10.7-6.6,12.4-12.4 C177.5,210.5,164.1,197,161,193.9z"/> </g> <g id="MotorBottom"> <path class="st0" d="M369.4,224c0,0-9.2-17-16.9-21.9c0,0-18-1-35.3,0.9c-9,1-25.4,6.9-34.1,10.6c-22.2,9.6-23,12-41.6,21.5 c-2.4,1.2,5.9,18.9-0.4,24.8c-4.7,4.4-7.4,27.7-7.4,27.7s-10.3-1.7-23.2,0.3c-5.3,0.8-46.3,11.4-46.3,11.4 c21.1,3.7,26.7,9.2,49.6,11.8c14.2,1.6,31,2,41.4,2c2.1-1.7,1.6-4.1,4.1-6.1c12.3-9.8,33.7-7,36.2,0c0.8,2.3-0.9,3.7,0,5.2 c2.8,4.7,24.5,3.1,36.4-8.9c13.7-13.9,1.3-28.8,15.1-50.7C356.9,237.1,369.4,224,369.4,224z"/> </g> <g id="Handle"> <path class="st0" d="M358.9,121.8L338.7,141c0,0-1.6-12.6-1.6-12.6c0,0,0,0,0,0s0,0,0,0c0,0.1-1.9,3-4.5,3.7 c-4.1,1.1-9.7-3.2-9.5-6.5c0.1-1.7,1.7-2.1,5.6-5.6c5.9-5.2,5.4-7.1,8.8-8.8c5.5-2.7,11.5-0.3,12.3,0 C350.5,111.6,358.9,121.8,358.9,121.8z"/> </g> <g id="SPLine1"> <path class="st1" d="M447.9,135.8h-178c-2.8,0-5.2-2.3-5.2-5.2l0,0c0-2.8,2.3-5.2,5.2-5.2h178c2.8,0,5.2,2.3,5.2,5.2l0,0 C453,133.5,450.7,135.8,447.9,135.8z"/> </g> <g id="SPLine2"> <path class="st2" d="M346.7,203.5H125.8c-3.7,0-6.7-3-6.7-6.7v0c0-3.7,3-6.7,6.7-6.7h220.9c3.7,0,6.7,3,6.7,6.7v0 C353.4,200.5,350.4,203.5,346.7,203.5z"/> </g> <g id="SPLine3"> <path class="st3" d="M433.9,236.7h-161c-2,0-3.6-1.6-3.6-3.6l0,0c0-2,1.6-3.6,3.6-3.6h161c2,0,3.6,1.6,3.6,3.6l0,0 C437.5,235,435.9,236.7,433.9,236.7z"/> </g> <g id="SPLine4"> <path class="st4" d="M310.1,97.1H34.7c-2.4,0-4.4-2-4.4-4.4v0c0-2.4,2-4.4,4.4-4.4h275.4c2.4,0,4.4,2,4.4,4.4v0 C314.5,95.2,312.5,97.1,310.1,97.1z"/> </g> </svg> </div>';
                        icondiv.style.marginBottom = "10px";
                        divmap.style.display = "block";
                        bardiv.innerHTML = '<div class="finished"></div> <div class="in-progress"><div class="percent"></div></div> <div class="unstarted"> </div>';
                        idfk.innerHTML = "<button type='submit' name='next' id='nextStep' value='next'>Next</button>";
                        statusname.innerHTML =  "<a>Worker Coming</a>";
                        break;
                    case "2":
                        divmap.style.display = "block";
                        icondiv.innerHTML = ' <div id="lawnMower"> <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 500 500" style="enable-background:new 0 0 500 500;" xml:space="preserve"> <style type="text/css"> .st01{fill:#096D38;} .st11{fill:#009444;} </style> <g id="RightWheel"> <path class="st01" d="M423.4,308.8c-13.3,0-24.2,10.8-24.2,24.2s10.8,24.2,24.2,24.2s24.2-10.8,24.2-24.2S436.7,308.8,423.4,308.8z M423.4,352.3c-10.7,0-19.3-8.7-19.3-19.3s8.7-19.3,19.3-19.3s19.3,8.7,19.3,19.3S434.1,352.3,423.4,352.3z"/> <path class="st01" d="M423.9,333c-3.7,4.1,2.1-15.8,8.8-17c5.4-0.9,13.5,8,9.5,12C440.3,329.8,431.9,324.1,423.9,333z"/> <path class="st01" d="M422.2,333c0.2-5.5,11.3,13.3,6.9,18.5c-3.5,4.1-16.7,3.4-16.2-2.2C413.1,346.8,421.7,344.9,422.2,333z"/> <path class="st01" d="M423.4,332c4.2,3.5-19.4,0.7-19.3-6.1c0-5.4,7.2-14.7,10.5-10.1C416,317.8,414.2,324.3,423.4,332z"/> </g> <g id="LeftWheel"> <path class="st01" d="M297.4,308.8c-13.3,0-24.2,10.8-24.2,24.2s10.8,24.2,24.2,24.2s24.2-10.8,24.2-24.2S310.7,308.8,297.4,308.8z M297.4,352.3c-10.7,0-19.3-8.7-19.3-19.3s8.7-19.3,19.3-19.3s19.3,8.7,19.3,19.3S308.1,352.3,297.4,352.3z"/> <path class="st01" d="M297.9,333c-3.7,4.1,2.1-15.8,8.8-17c5.4-0.9,13.5,8,9.5,12C314.3,329.8,305.9,324.1,297.9,333z"/> <path class="st01" d="M296.2,333c0.2-5.5,11.3,13.3,6.9,18.5c-3.5,4.1-16.7,3.4-16.2-2.2C287.1,346.8,295.7,344.9,296.2,333z"/> <path class="st01" d="M297.4,332c4.2,3.5-19.4,0.7-19.3-6.1c0-5.4,7.2-14.7,10.5-10.1C290,317.8,288.2,324.3,297.4,332z"/> </g> <g id="MowerBody"> <path class="st01" d="M39.3,147c9.3,0,34,0,70.6,0c10.2,0,21.3,7.5,36.5,20.5c27.9,24,53.9,53.9,69.5,69.5c1.3,1.3-2.1,8-4.1,6 c-15-15-69.8-78.6-98.3-86.7c-15-4.3-42.5-3.4-69.6-3.4C37.9,152.9,36.3,147,39.3,147z"/> <path class="st11" d="M242.6,290.2h213.6c17.5,0,31.7,14.3,31.7,31.7v7.6c0,2.4-2,4.4-4.4,4.4H242.6c-6.6,0-12-5.4-12-12v-19.7 C230.6,295.6,236,290.2,242.6,290.2z"/> <path class="st11" d="M283.8,262.8h121.9c9.7,0,17.6,7.9,17.6,17.6v5.2c0,3.9-3.2,2-7.2,2H273.4c-3.9,0-7.2-0.2-7.2-4.2v-3 C266.2,270.7,274.2,262.8,283.8,262.8z"/> <path class="st11" d="M323.1,243h44c7.8,0,14.1,6.4,14.1,14.1v5.7H310v-6.7C310,248.9,315.9,243,323.1,243z"/> <path class="st11" d="M245.4,321.7h-86.3c-6.6,0-12-5.4-12-12v-76.3c0-6.6,5.4-12,12-12h50.5c6.6,0,19.4,0,24.8,12l42.2,80.7 C276.6,320.7,252,321.7,245.4,321.7z"/> <path class="st11" d="M12.1,147c9.3,0,34,0,70.6,0c10.2,0,21.3,7.5,36.5,20.5c27.9,24,53.9,53.9,69.5,69.5c1.3,1.3-2.1,8-4.1,6 c-15-15-69.8-78.6-98.3-86.7c-15-4.3-42.5-1.4-69.6-1.4C10.6,154.9,9,147,12.1,147z"/> </g> </svg> </div>'
                        icondiv.style.marginBottom = "10px";
                        bardiv.innerHTML = '<div class="finished"></div> <div class="finished"></div> <div class="in-progress"><div class="percent"></div></div>';
                        statusname.innerHTML =  "<a>Working</a>";
                        break;
                    case "3":
                        idfk.innerHTML = "<button type='submit' name='next' id='nextStep' value='finished'>Finish</button>";
                        divmap.style.display = "none";
                        icondiv.innerHTML = ' <div id="checkSign"> <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 500 500" style="enable-background:new 0 0 500 500;" xml:space="preserve"> <style type="text/css"> .st02{fill:#009444;} </style> <rect x="319.5" y="-24.7" transform="matrix(-0.866 -0.5 0.5 -0.866 516.2603 634.179)" class="st02" width="47.1" height="545.3"/> <polygon class="st02" points="30.6,328.1 7,368.9 227.2,495.8 249,454.2 "/> </svg> </div>'                        
                        icondiv.style.marginBottom = "10px";
                        if (cancelBtn.parentNode != null) {
                            cancelBtn.parentNode.removeChild(cancelBtn);
                        }
                        bardiv.innerHTML = '<div class="finished"></div> <div class="Finished"></div> <div class="finished"></div>';
                        statusname.innerHTML =  "<a>Finished</a>";
                        //console.log("plm");
                        //setTimeout(function (){window.location.reload(true);}, 5000);
                        idfk.innerHTML = "<button type='submit' name='next' id='nextStep' value='finished'>Finish</button>";
                        break;}
                    },
                    error: function(result){
                        console.log(result);
                    }
        });
    }

    function noFetch(){
        alert("unable to get position");
    }

}