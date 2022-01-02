function insertLocation()
{
    var country = document.getElementById("country");
    var county = document.getElementById("county");
    var city = document.getElementById("city");
    var street = document.getElementById("street");
    var pcode = document.getElementById("pcode");


    if(navigator.geolocation)
    {
        console.log(navigator.geolocation);
        navigator.geolocation.getCurrentPosition(showPos, rejectPos);
    }

    function showPos(position)
    {
        let url = `https://nominatim.openstreetmap.org/reverse?format=json&lat=${position.coords.latitude}&lon=${position.coords.longitude}`;
        fetch(url)
        .then(response => response.json() )
        .then(data =>{
            console.log(data);
            //addressBar.value = data.address.country + ", " + data.address.city + ", " + data.address.road + ", " + data.address.postcode;
            if(data.address.state==null || data.address.city==null){
                if(data.address.state==null){
                    country.value = data.address.country;
                    county.value = data.address.county;
                    city.value = data.address.city;
                    street.value = data.address.road;
                    pcode.value = data.address.postcode;
                }
                if(data.address.city==null){
                    country.value = data.address.country;
                    county.value = data.address.state;
                    city.value = data.address.district;
                    street.value = data.address.road;
                    pcode.value = data.address.postcode;
                }
                if(data.address.city==null && data.address.state==null){
                    country.value = data.address.country;
                    county.value = data.address.county;
                    city.value = data.address.district;
                    street.value = data.address.road;
                    pcode.value = data.address.postcode;
                }
            }
            else
            {
                country.value = data.address.country;
                county.value = data.address.state;
                city.value = data.address.city;
                street.value = data.address.road;
                pcode.value = data.address.postcode;
            }
            
        })
        
    }

    function rejectPos()
    {
        console.log("Localization was unsuccessful");
        alert("Localization was unsuccessful!");
    }
}