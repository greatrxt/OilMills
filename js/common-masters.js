var brokerArray = null;
var locationsArray = null;
/*$(window).ready(function() {
	NProgress.start();
	$.ajaxSetup({
		  headers : {
			'Authorization' : 'Bearer ' + localStorage.getItem("token")
		  }
	});

	NProgress.inc();
	if(document.getElementById('unitOfMeasurement')!=null){
	//load uom
	 $.getJSON(base_url + "/AdValoramAdmin/common/unitOfMeasurement", function(data){
			 if(data.result=='error'){
				return;
			 }
			var uomArray = data.result;
			var uomSelect = document.getElementById('unitOfMeasurement');
			removeOptions(uomSelect);
			for(var i = 0; i < uomArray.length; i++){
				var uom = uomArray[i];
					var opt = document.createElement('option');
					opt.value = uom.id;
					opt.innerHTML = uom.description;
					uomSelect.appendChild(opt);
			}
		});
	}
	NProgress.inc();
	if(document.getElementById('productCategory')!=null){
			//load productCategory
		 $.getJSON(base_url + "/AdValoramAdmin/common/productCategory", function(data){
				if(data.result=='error'){
					return;
				 }
				productCategoryArray = data.result;
				var productCategorySelect = document.getElementById('productCategory');
				removeOptions(productCategorySelect);
				for(var i = 0; i < productCategoryArray.length; i++){
					var productCategory = productCategoryArray[i];
						var opt = document.createElement('option');
						opt.value = productCategory.id;
						opt.innerHTML = productCategory.categoryName;
						productCategorySelect.appendChild(opt);
				}
			});
	}

	NProgress.inc();
	
	if(document.getElementById('linkedBroker')!=null){
			//load broker
		 $.getJSON(base_url + "/AdValoramAdmin/customer/broker", function(data){
			var brokerSelect = document.getElementById('linkedBroker');			
			removeOptions(brokerSelect);
			if(brokerSelect!=null) brokerSelect.disabled = true;
			if(data.result=='error'){
				return;
			}
			
			brokerArray = data.result;
			if(brokerArray.length > 0){
				brokerSelect.disabled = false;
			}			

			for(var i = 0; i < brokerArray.length; i++){
				var broker = brokerArray[i];
				var opt = document.createElement('option');
				opt.value = broker.id;
				opt.innerHTML = broker.companyName;
				brokerSelect.appendChild(opt);
			}
			brokerSelect.selectedIndex = -1;
		});
	}
	
	NProgress.done();
	});*/

	
	function refreshLocationDistrictAndState(){
		if(document.getElementById('city') == null || document.getElementById('state') == null
			|| document.getElementById('district') == null)
			return;
		var district = document.getElementById('district');
		var state = document.getElementById('state');
		var city = document.getElementById('city');

		district.value = '';
		state.value = '';

		if(locationsArray!=null){
			for(var i = 0; i < locationsArray.length; i++){
				var location = locationsArray[i];
				if(city.options[city.selectedIndex].text.localeCompare(location.cityName) == 0){
					district.value = location.district;
					state.value = location.state;
				}
			}
		}
	}
