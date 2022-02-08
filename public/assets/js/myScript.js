var charge =document.getElementById('charge');
var sousCharge =document.getElementById('sousCharge');
charge.addEventListener('change',function(){
    var valueCharge =this.value;
    if(valueCharge == "Charge simple")
    {
        sousCharge.innerHTML="<option value='Charge simple'>Charge simple</option>";
    }
    if(valueCharge == "Charge fix")
    {
        sousCharge.innerHTML="<option value='fix'>Fix</option> <option value='Abonnement'>Abonnement</option> <option value='Diesel'>Diesel</option> <option value='louer'>louer</option>";
    }

    if(valueCharge == "Charge fournisseur")
    {
        sousCharge.innerHTML="<option value='Charge fournisseur'>Charge fournisseur</option>";
    }
});

  
  
  