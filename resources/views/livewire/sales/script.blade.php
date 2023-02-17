<script>


function openModal(prodId, currentChanges, productName) {
		console.log(prodId, currentChanges, productName)
		var modal = document.getElementById("modalChanges")
		document.getElementById('changesProduct').value = currentChanges
		@this.productIdSelected = prodId
		@this.productChangesSelected = currentChanges
		@this.productNameSelected = productName
		modal.classList.add("overflow-y-auto", "show")
		modal.style.cssText = "margin-top: 0px; margin-left: -100px;  z-index: 10000;"
	}

    
	function openModalCustomer() {
		var modal = document.getElementById("modalCustomer")
		modal.classList.add("overflow-y-auto", "show")
		modal.style.cssText = "margin-top: 0px; margin-left: -100px;  z-index: 1000;"
	}

    function closeModalCustomer() {
		var modal = document.getElementById("modalCustomer")
		modal.classList.remove("overflow-y-auto", "show")
		modal.style.cssText = ""
	}

    
	function closeModal() {
		var modal = document.getElementById("modalChanges")
		modal.classList.remove("overflow-y-auto", "show")
		modal.style.cssText = ""             
	}

 // events listeners
 window.addEventListener('close-modal-changes', event => {
         	closeModal()
         })
         window.addEventListener('close-customer-modal', event => {
         	closeModalCustomer()
         })

         // sync properties values
         const input = document.getElementById('customer-search')
         input.addEventListener('change', (e) => {
         	@this.searchcustomer = e.target.value;
         })
         const inputCash = document.getElementById('cash')
         inputCash.addEventListener('change', (e) => {
         	@this.cash = e.target.value;
         })


         document.addEventListener('click', (e) => {
         	//console.log(e.target.getAttribute('data-kioskboard-type'))
         	if (e.target.getAttribute('data-type') === 'qty') {
         		KioskBoard.run('#' + e.target.id, {})
         		document.getElementById(e.target.id).blur()
         		document.getElementById(e.target.id).focus()

         	}
         })

         // sync properties values
         const input = document.getElementById('customer-search')
         input.addEventListener('change', (e) => {
         	@this.searchcustomer = e.target.value;
         })
         const inputCash = document.getElementById('cash')
         inputCash.addEventListener('change', (e) => {
         	@this.cash = e.target.value;
         })
      
	
</script>