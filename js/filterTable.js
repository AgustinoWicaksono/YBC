function filterTable(term, table) {
	dehighlight(table);
	var terms = term.value.toLowerCase().split(" ");

	for (var r = 1; r < table.rows.length; r++) {
		var display = '';
		for (var i = 0; i < terms.length; i++) {
			if (table.rows[r].innerHTML.replace(/<[^>]+>/g, "").toLowerCase()
				.indexOf(terms[i]) < 0) {
				display = 'none';
			} else {
				if (terms[i].length) highlight(terms[i], table.rows[r]);
			}
			table.rows[r].style.display = display;
		}
	}
}


function dehighlight(container) {
	for (var i = 0; i < container.childNodes.length; i++) {
		var node = container.childNodes[i];

		if (node.attributes && node.attributes['class']
			&& node.attributes['class'].value == 'highlighted') {
			node.parentNode.parentNode.replaceChild(
					document.createTextNode(
						node.parentNode.innerHTML.replace(/<[^>]+>/g, "")),
					node.parentNode);
			// Stop here and process next parent
			return;
		} else if (node.nodeType != 3) {
			// Keep going onto other elements
			dehighlight(node);
		}
	}
}

function highlight(term, container) {
	for (var i = 0; i < container.childNodes.length; i++) {
		var node = container.childNodes[i];

		if (node.nodeType == 3) {
			// Text node
			var data = node.data;
			var data_low = data.toLowerCase();
			if (data_low.indexOf(term) >= 0) {
				//term found!
				var new_node = document.createElement('span');

				node.parentNode.replaceChild(new_node, node);

				var result;
				while ((result = data_low.indexOf(term)) != -1) {
					new_node.appendChild(document.createTextNode(
								data.substr(0, result)));
					new_node.appendChild(create_node(
								document.createTextNode(data.substr(
										result, term.length))));
					data = data.substr(result + term.length);
					data_low = data_low.substr(result + term.length);
				}
				new_node.appendChild(document.createTextNode(data));
			}
		} else {
			// Keep going onto other elements
			highlight(term, node);
		}
	}
}

function create_node(child) {
	var node = document.createElement('span');
	node.setAttribute('class', 'highlighted');
	node.attributes['class'].value = 'highlighted';
	node.appendChild(child);
	return node;
}

tables = document.getElementsByTagName('table');
for (var t = 0; t < tables.length; t++) {
	element = tables[t];

	if (element.attributes['class']
		&& element.attributes['class'].value == 'filterable') {

		var form = document.createElement('form');
		form.setAttribute('class', 'tabfilter');
		form.attributes['class'].value = 'tabfilter';
		var input = document.createElement('input');
		input.setAttribute('class','input_text');
		input.attributes['class'].value = 'input_text';
		input.onkeyup = function() {
			filterTable(input, element);
		}

		var teksdiv = document.createElement('span');
		teksdiv.innerHTML='<strong style="color:#335070">Cari: </strong>';
		var teksdiv2 = document.createElement('span');
		teksdiv2.innerHTML='&nbsp; <em style="color:#376091">Isi kotak pencarian untuk mencari kode material atau barang. Atau kosongkan untuk menampilkan semua.</em>';
		form.appendChild(teksdiv);
		form.appendChild(input);
		form.appendChild(teksdiv2);
		element.parentNode.insertBefore(form, element);
	}
}

