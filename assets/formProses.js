class formProses {
	constructor(url, tbl) {
		this.tbl = tbl;
		this.url = url;
	}

	tambah(data, tbl = '') {
		const response = jQuery.ajax({
			type: "POST",
			url: this.url,
			dataType: 'JSON',
			data: {
				manajemen: 'tambah',
				tbl: tbl != '' ? tbl : this.tbl,
				...data
			},
			async: false
		});

		return response.responseJSON;
	}

	upload(data, tbl = '') {
		const response = jQuery.ajax({
			url: this.url,
			type: 'POST',
			data: data,
			cache: false,
			contentType: false,
			processData: false,
			dataType: "JSON",
			async: false
		})

		return response.responseJSON;
	}

	update(data, where = {}) {
		const response = jQuery.ajax({
			type: "POST",
			url: this.url,
			dataType: 'JSON',
			data: {
				manajemen: 'update',
				tbl: this.tbl,
				where: where,
				...data
			},
			async: false
		});

		return response.responseJSON;
	}

	hapus(where = {}) {
		const response = jQuery.ajax({
			type: "POST",
			url: this.url,
			dataType: "JSON",
			data: {
				manajemen: "hapus",
				tbl: this.tbl,
				where: where
			},
			async: false
		});

		return response.responseJSON;
	}

	kirimNotikasi(url, title, body, token){
		const data = {title,body,token};
		const response = $.ajax({
			type: 'POST',
			url: url,
			dataType: "JSON",
			data: data
		})
	}

	getData(url = '', data = {}, type = 'POST') {
		const response = $.ajax({
			type: type,
			url: url,
			dataType: "JSON",
			data: data,
			async: false
		})

		return response.responseJSON;
	}

	async cekData(url = '', tbl, send) {
		const res = jQuery.ajax({
			type: "POST",
			url: url,
			dataType: 'json',
			data: {
				tabel: tbl,
				data: send
			},
			async: false
		})

		return await res.responseJSON;
	}
}
