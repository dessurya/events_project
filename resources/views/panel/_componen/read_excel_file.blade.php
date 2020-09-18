<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.8.0/jszip.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.8.0/xlsx.js"></script>
<script>
    function readExcelFile(file) {
		let jsonStringfyOfDoc = {};
		var reader = new FileReader();
		reader.onload = function(e) {
			var data = e.target.result;
			var workbook = XLSX.read(data, { type: 'binary' });
			workbook.SheetNames.forEach(function(sheetName) {
				var XL_row_object = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[sheetName]);
				jsonStringfyOfDoc[sheetName] = XL_row_object;
				// var json_object = JSON.stringify(XL_row_object);
				// jsonStringfyOfDoc[sheetName] = json_object;
			});
		};
		reader.onerror = function(ex) { jsonStringfyOfDoc['error'] = ex; };
		reader.readAsBinaryString(file);
		return jsonStringfyOfDoc;
	}
</script>