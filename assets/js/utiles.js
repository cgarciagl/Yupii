if (!console) {
	console = {};
	console.log = function () {
	};
}

if (typeof String.prototype.trim != 'function') {
	String.prototype.trim = function (str) {
		return $.trim(str);
	};
}

if (typeof String.prototype.startsWith != 'function') {
	String.prototype.startsWith = function (str) {
		return this.slice(0, str.length) == str;
	};
}

if (typeof String.prototype.endsWith != 'function') {
	String.prototype.endsWith = function (str) {
		return this.slice(-str.length) == str;
	};
}

if (typeof String.prototype.replaceAll != 'function') {
	String.prototype.replaceAll = function (find, replace) {
		var str = this;
		return str.replace(new RegExp(find.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&'), 'g'), replace);
	};
}

if (typeof (base_url) == "undefined") {
	var getUrl = window.location;
	var base_url = getUrl.protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
	if (!(base_url.endsWith('/'))) {
		base_url = base_url + '/';
	}
}

function fixUrl(purl) {
	if ((purl.startsWith('http://')) || (typeof (base_url) == "undefined")) {
		return purl;
	} else {
		return base_url + 'index.php/' + purl;
	}
}

var ResultData = {};

function getValue(purl, pparameters, callbackfunction) {
	var valor = 'N/A_';
	if (callbackfunction) {
		asinc = true;
	} else {
		asinc = false;
	}
	$.ajax({
		url: fixUrl(purl),
		type: 'POST',
		data: pparameters,
		async: asinc,
		cache: false,
		dataType: 'text',
		timeout: 30000,
		error: function (a, b) {
			valor = b;
		},
		success: function (msg) {
			valor = msg;
			if (callbackfunction) {
				callbackfunction(valor);
			}
		}
	});
	return valor;
}

function getObject(purl, pparameters, callbackfunction) {
	if (callbackfunction) {
		getValue(purl, pparameters, function (s) {
			var obj = (new Function('return ' + s))();
			callbackfunction(obj);
		});
	} else {
		var t = getValue(purl, pparameters);
		return (new Function('return ' + t))();
	}
}

function redirectTo(purl) {
	setTimeout(function () {
		window.location.href = fixUrl(purl);
	}, 0);
}

function openInNew(purl) {
	window.open(fixUrl(purl), "_new");
}

function redirectByPost(purl, pparameters, in_new_tab) {
	var url = fixUrl(purl);
	pparameters = (typeof pparameters == 'undefined') ? {} : pparameters;
	in_new_tab = (typeof in_new_tab == 'undefined') ? true : in_new_tab;
	var form = document.createElement("form");
	$(form).attr("id", "reg-form").attr("name", "reg-form").attr("action", url).attr("method", "post").attr("enctype", "multipart/form-data");
	if (in_new_tab) {
		$(form).attr("target", "_blank");
	}
	$.each(pparameters, function (key) {
		$(form).append('<input type="text" name="' + key + '" value="' + this + '" />');
	});
	document.body.appendChild(form);
	form.submit();
	document.body.removeChild(form);
	return false;
}

function trim(inputString) {
	return $.trim(inputString);
}

function refreshPage() {
	location.reload();
}

function getHourNumber() {
	return (new Date().getTime());
}

var timestamp = getHourNumber();

function moveElement(elem, to) {
	elem.appendTo(to);
}

$.fn.serializeObject = function () {
	var o = {};
	var a = this.serializeArray();
	$.each(a, function () {
		if (o[this.name]) {
			if (!o[this.name].push) {
				o[this.name] = [o[this.name]];
			}
			o[this.name].push(this.value || '');
		} else {
			o[this.name] = this.value || '';
		}
	});
	return o;
};

$.fn.shake = function (options) {
	var settings = {
		'shakes': 2,
		'distance': 10,
		'duration': 400
	};
	if (options) {
		$.extend(settings, options);
	}
	var pos;
	return this.each(function () {
		var $this = $(this);
		pos = $this.css('position');
		if (!pos || pos === 'static') {
			$this.css('position', 'relative');
		}
		for (var x = 1; x <= settings.shakes; x++) {
			$this.animate({left: settings.distance * -1}, (settings.duration / settings.shakes) / 4)
			.animate({left: settings.distance}, (settings.duration / settings.shakes) / 2)
			.animate({left: 0}, (settings.duration / settings.shakes) / 4);
		}
	});
};

$(document).ajaxStart(function () {
	$.blockUI({message: '<h1><i class="fa fa-spinner fa-spin"></i></h1>'});
}).ajaxStop(function () {
	$.unblockUI()
});

function ponTotalesEnTabla(t, enRenglonFinal, enColumnaFinal) {
	enRenglonFinal = (typeof enRenglonFinal !== 'undefined') ? enRenglonFinal : false;
	enColumnaFinal = (typeof enColumnaFinal !== 'undefined') ? enColumnaFinal : true;
	if (t.find('tr:eq(0) td:last').text() != 'Total') {
		var renglones = t.find('tbody').find('tr').length;
		var cols = t.find('tbody').find('tr:last-child').find('td').length;
		if ((enRenglonFinal) && (renglones > 1)) {
			s = '';
			t.find('tbody').append('<tr></tr>');
			lr = t.find('tbody').find('tr:last-child');
			for (i = 1; i <= cols; i++) {
				lr.append('<td style="font-weight:bold">Total</td>');
			}
			for (i = 1; i <= cols - 1; i++) {
				tt = 0;
				for (j = 0; j <= renglones - 1; j++) {
					tt = tt + parseInt(t.find('tbody').find('tr').eq(j).find('td').eq(i).text());
				}
				lr.find('td').eq(i).text(tt);
			}
		}
		if ((enColumnaFinal) && (cols > 2)) {
			t.find('tr').append('<td style="font-weight:bold">Total</td>');
			for (j = 0; j <= renglones - 1; j++) {
				tt = 0;
				rr = t.find('tbody').find('tr').eq(j);
				for (i = 1; i <= cols - 1; i++) {
					tt = tt + parseInt(rr.find('td').eq(i).text());
				}
				rr.find('td').eq(cols).text(tt);
			}
		}
	}
}

function exportToExcel(fileName, htmls){
	var uri = 'data:application/vnd.ms-excel;charset=UTF-8;base64,';
	var template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head> <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> <meta charset="utf-8" />  <!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>';
	var base64 = function(s) {
		return window.btoa(unescape(encodeURIComponent(s)))
	};

	var format = function(s, c) {
		return s.replace(/{(\w+)}/g, function(m, p) {
			return c[p];
		})
	};

	var ctx = {
		worksheet : 'Worksheet',
		table : htmls
	}

	var link = document.createElement("a");
	document.body.appendChild(link);
	link.download = fileName + ".xls";
	link.href = uri + base64(format(template, ctx));
	link.click();
	link.remove();

}
