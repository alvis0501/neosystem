function searchEmployee() {
    var inputValue = $('#employee_key_input').val();
    $('#employee_key').val(inputValue);
    $('#employee_get_form').submit();
}

function addOtherMailInput() {
    if ($('.other_mail_input').length > 10) {
        alert('申請者以外の連絡先メールアドレスは最大10件までです。');
        return false;
    }
    var copyHtml = $('#other_mails_ref').html();
    $('#other_mails').append("<br>" + copyHtml);
}

function addDestinationInput() {
    if ($('.destination_input').length > 10) {
        alert('データ提供先（属性）は最大10件までです。');
        return false;
    }
    var copyHtml = $('#destinations_ref').html();
    $('#destinations').append("<br>" + copyHtml);
}

function submitAction(url) {
    $('form').attr('action', url);
    $('form').submit();
}

function delDataUsageTypeTr(num) {
	console.log('delDataUsageTypeTr');
	console.log(num);
	console.log($('body').find("input[type='button'][id^=data-del" + num + "]").val());
	console.log($('body').find("input[type='button'][id^=data-del]").length);

	if ($('body').find("input[type='button'][id^=data-del]").length <= 1) {
		alert('データ利用/提供目的は1件以上必要です');
		return;
	}

	$('body').find("input[type='button'][id^=data-del" + num + "]").closest('tr').remove();
	var existing_tag = $('body').find("input[type='hidden'][name^=purposes\\[" + num + "][name$=fugi_data_usage_type_id\\]]");
	var existing_id = existing_tag.val();
	existing_tag.remove();
	console.log(existing_id);
	var ids = $('body').find("input[type='hidden'][id=del_fdut_id]").val();
	$('body').find("input[type='hidden'][id=del_fdut_id]").val(ids + ',' + existing_id);
	//var m_name = $(this).attr('id');
	//console.log(m_name);
}

function delEditMinorDataUsageTypeTr(minor_change_idx, num) {
	console.log('delEditMinorDataUsageTypeTr');
	console.log('minor_change_idx='+minor_change_idx);
	console.log('num='+num);
	var delbutton = $('body').find("input[type='button'][id^=minor-data-del"+ minor_change_idx + "-" + num + "]");
	console.log(delbutton.val());
	//delbutton.closest('tr').hide();
	//delbutton.closest('tr').prop('disabled', true);
	delbutton.closest('tr').remove();
	/*
	var existing_tag = $('body').find("input[type='hidden'][name^=purposes\\[" + num + "][name$=fugi_data_usage_type_id\\]]");
	var existing_id = existing_tag.val();
	existing_tag.remove();
	console.log(existing_id);
	var ids = $('body').find("input[type='hidden'][id=del_fdut_id]").val();
	$('body').find("input[type='hidden'][id=del_fdut_id]").val(ids + ',' + existing_id);
	*/
	//var m_name = $(this).attr('id');
	//console.log(m_name);
}

function delMinorDataUsageTypeTr(num) {
	console.log('delMinorDataUsageTypeTr');
	console.log(num);
	var delbutton = $('body').find("input[type='button'][id^=minor-data-del" + num + "]");
	console.log(delbutton.val());
	//delbutton.closest('tr').hide();
	//delbutton.closest('tr').prop('disabled', true);
	delbutton.closest('tr').remove();
	/*
	var existing_tag = $('body').find("input[type='hidden'][name^=purposes\\[" + num + "][name$=fugi_data_usage_type_id\\]]");
	var existing_id = existing_tag.val();
	existing_tag.remove();
	console.log(existing_id);
	var ids = $('body').find("input[type='hidden'][id=del_fdut_id]").val();
	$('body').find("input[type='hidden'][id=del_fdut_id]").val(ids + ',' + existing_id);
	*/
	//var m_name = $(this).attr('id');
	//console.log(m_name);
}

function setTooltipDataIntroduction() {
	// ツールチップ
	$(".data-introduction").tooltip({
		show:false,
		hide:false,
		content:"a: 通信の秘密/位置情報<br>b: センシティブ情報<br>c: 財産に関する情報<br>d: 行動履歴（利用履歴）<br>e: 行動履歴（取引履歴）<br>f: 特定個人識別性が高い画像等<br>g: 身体・容姿に関する情報<br>h: その他",
		position: {
			my: "center bottom-5",
			at: "center top"
		}
	});
}

function addDataUsageTypeTr() {
	console.log('addDataUsageTypeTr()');
    var tableRowLength = $('#data_usage_type_table tr').length;
    if (tableRowLength > 8) {
        alert('データ利用/提供目的は最大9件までです。');
        return false;
    }

	var max = 0;
	$('[name^=purposes][name$=\\[purpose\\]]').each(function(){ // nameが「purposes」で始まって「[purpose]」で終わるselect全部をループで回す
		var m_name = $(this).attr('name'); // 各要素のname名を取得
		console.log(m_name);
		var ret = m_name.match(/[0-9]+/);
		console.log(ret);
		var number = Number(ret[0]);
		if (max < number) {
			max = number;
		}
		console.log('max='+max);
	});
	var next = max + 1;

    var html = $('#data_usage_type_table tr').eq(0)[0].outerHTML;
    html = html.replace(/\[[0-9]+\]/g, "[" + next + "]");
    html = html.replace(/data-introduction[0-9]+/g, "data-introduction" + next);
    html = html.replace(/data-del[0-9]+/g, "data-del" + next);
    html = html.replace(/delDataUsageTypeTr\([0-9]+\)/g, "delDataUsageTypeTr(" + next + ")");
    html = html.replace(/checked=\"checked\"/g, "");
    $('#data_usage_type_table').append(html);

	setTooltipDataIntroduction();
}

function addEditDataUsageTypeTrWithMinorChange(minor_change_idx) {
	console.log('addEditDataUsageTypeTrWithMinorChange()');
	console.log('minor_change_idx='+minor_change_idx);
	var tableRowLength = $('#edit_data_usage_type_table_minor_change'+ minor_change_idx +' tr').length;
	console.log('tableRowLength='+tableRowLength);
	if (tableRowLength > (8 + 1)) { // 増殖元1件を含んだ数で比較
		alert('データ利用/提供目的は最大9件までです。');
		return false;
	}

	var max = 0;
	$('[name^=edit_minor_change_purposes\\['+ minor_change_idx +'][name$=\\[purpose\\]]').each(function(){ // nameが「edit_minor_change_purposes」で始まって「[purpose]」で終わるselect全部をループで回す
		var m_name = $(this).attr('name'); // 各要素のname名を取得
		console.log('m_name='+m_name);
		var ret = m_name.match(/[0-9]+/g);
		console.log(ret);
		var number = Number(ret[1]); // 2個目の数値
		if (max < number) {
			max = number;
		}
		console.log('max='+max);
	});
	var next = max + 1;
	console.log('next='+next);

	console.log('eq(0)[0]='+$('#edit_data_usage_type_table_minor_change'+ minor_change_idx +' tr').eq(0)[0]);
	var html = $('#edit_data_usage_type_table_minor_change'+ minor_change_idx +' tr').eq(0)[0].outerHTML;
	//html.show();
	html = html.replace(/display:none;/g, "");
	html = html.replace(/display:/g, ""); // IE対策
	html = html.replace(/none;/g, ""); // IE対策
	html = html.replace(/\[[0-9]+\]\[[0-9]+\]/g, "[" + minor_change_idx + "]" + "[" + next + "]");
	html = html.replace(/data-introduction[0-9]+/g, "data-introduction" + next);
	html = html.replace(/data-del[0-9]+/g, "data-del"+ minor_change_idx + "-" + next);
	html = html.replace(/delEditMinorDataUsageTypeTr\([0-9]+\)/g, "delEditMinorDataUsageTypeTr(" + minor_change_idx + "," + next + ")");
	html = html.replace(/checked=\"checked\"/g, "");
	$('#edit_data_usage_type_table_minor_change'+ minor_change_idx).append(html);
	//console.log('html='+html);

	setTooltipDataIntroduction();

	$('[name^=edit_minor_change_purposes][name$=purpose\\]]').trigger('change');

}

function addDataUsageTypeTrWithMinorChange() {
	console.log('----------------------------------------');
	console.log('addDataUsageTypeTrWithMinorChange()');
    var tableRowLength = $('#data_usage_type_table_minor_change tr').length;
	console.log('tableRowLength='+tableRowLength);
    if (tableRowLength > (8 + 1)) { // 増殖元1件を含んだ数で比較
        alert('データ利用/提供目的は最大9件までです。');
        return false;
    }

	var max = 0;
	$('[name^=minor_change_purposes][name$=\\[purpose\\]]').each(function(){ // nameが「minor_change_purposes」で始まって「[purpose]」で終わるselect全部をループで回す
		var m_name = $(this).attr('name'); // 各要素のname名を取得
		console.log('m_name='+m_name);
		var ret = m_name.match(/[0-9]+/);
		console.log(ret);
		var number = Number(ret[0]);
		if (max < number) {
			max = number;
		}
		console.log('max='+max);
	});
	var next = max + 1;
	console.log('next='+next);

    var html = $('#data_usage_type_table_minor_change tr').eq(0)[0].outerHTML;
	console.log('before html='+html);
    //html.show();
    html = html.replace(/display:none;/g, "");
    html = html.replace(/display:/g, ""); // IE対策
    html = html.replace(/none;/g, ""); // IE対策
    html = html.replace(/\[[0-9]+\]/g, "[" + next + "]");
    html = html.replace(/data-introduction[0-9]+/g, "data-introduction" + next);
    html = html.replace(/data-del[0-9]+/g, "data-del" + next);
    html = html.replace(/delMinorDataUsageTypeTr\([0-9]+\)/g, "delMinorDataUsageTypeTr(" + next + ")");
    html = html.replace(/checked=\"checked\"/g, "");
    $('#data_usage_type_table_minor_change').append(html);
	console.log('after html='+html);

	setTooltipDataIntroduction();

	$('[name^=minor_change_purposes][name$=purpose\\]]').trigger('change');
}

function openOutlook(toMail, subject, messageBody) {
    location.href = 'mailto:' + toMail + '?subject=' + subject + '&body=' + messageBody;
}

function toggleMinorChange() {
    if ($('input[name=is_minor_change]:eq(1)').prop('checked') == true) {
        $('input[name=is_minor_change]:eq(0)').attr('readonly', true);
        $('input[name=is_minor_change]:eq(1)').attr('readonly', true);
        $('.minor_change_date').show();
        $('.minor_change_content').show();
        $('.data_usage_type').show();
    }
}

function addMinorChange() {
    $('input[name=is_minor_change]:eq(0)').attr('readonly', true);
    $('input[name=is_minor_change]:eq(1)').attr('readonly', true);
    $('.minor_change_date').show();
    $('.minor_change_content').show();
    $('.data_usage_type').show();
    $('#add_minor_change_button').hide();

	$('[name^=minor_change_purposes][name$=purpose\\]]').trigger('change');
}

function setMinorChangeToday() {
    var today = new Date();
    var year = today.getFullYear();
    var month = today.getMonth() + 1;
    var day = today.getDate();
    $('input[name=change_date]').val(year + '/' + month + '/' + day);
}

function setEditMinorChangeToday(index) {
    var today = new Date();
    var year = today.getFullYear();
    var month = today.getMonth() + 1;
    var day = today.getDate();
    $('input[name=edit_change_date\\['+ index +'\\]]').val(year + '/' + month + '/' + day);
}

function isDate(strDate){
	// 空文字は無視
	if(strDate == ""){
		return true;
	}
	// 年/月/日の形式のみ許容する
	if(!strDate.match(/^\d{4}\/\d{1,2}\/\d{1,2}$/)){
		return false;
	}

	// 日付変換された日付が入力値と同じ事を確認
	// new Date()の引数に不正な日付が入力された場合、相当する日付に変換されてしまうため
	//
	var date = new Date(strDate);
	if(date.getFullYear() !=  strDate.split("/")[0]
	    || date.getMonth() != strDate.split("/")[1] - 1
	    || date.getDate() != strDate.split("/")[2]
	){
		return false;
	}

	return true;
}

function switchHiddenTable() {
	if ($('#hidden_table').is(':hidden')) {
		$('#hidden_table').show();
		$('#other_area').text('▲');
	} else {
		$('#hidden_table').hide();
		$('#other_area').text('▼');
	}
}

