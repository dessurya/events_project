<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.8.0/jszip.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.8.0/xlsx.js"></script>
<script>
    function readExcelFile(file, id) {
		var reader = new FileReader();
		reader.onload = function(e) {
			var data = e.target.result;
			var result = {};
			var workbook = XLSX.read(data, { type: 'binary' });
			workbook.SheetNames.forEach(function(sheetName) {
				var XL_row_object = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[sheetName]);
				result[sheetName] = XL_row_object;
				var doLoop = 1;
				while (XL_row_object.length > 0){ 
					var check = renderFormImport(XL_row_object.splice(0,25), id, doLoop, sheetName)
					if (check == false) { throw "exit" }
					doLoop = doLoop+1
				}
			});
		};
		reader.readAsBinaryString(file);
	}
</script>