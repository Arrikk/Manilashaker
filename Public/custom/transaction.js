$(document).ready(function(){
    let transactions;
    let paginated;
    let page = 1;
    let limit = 20;


    const transactionItem = (e) => {
        $('#transaction-item').append(`
            <tr>
                <td class="nowrap">
                <span class="status-pill smaller ${e.type == 0 ? 'green' : "red"}"></span><span>${e.type == 0 ? 'Credit' : "Debit"}</span>
                </td>
                <td>
                <span class="smaller lighter">${e.date}</span>
                </td>
                <td class="cell-with-media">
                <img alt="" src="${e.image ? '/Public/images/'+e.image :'/Public/img/no-avatar.png'}" style="height: 25px;"><span> ${e.description} </span>
                </td>
                <td class="text-center">
                    <a class="badge badge-dark text-white">${e.phone}</a>
                <td class="text-center">
                    <a class="badge badge-warning">${e.email}</a>
                </td>
                <td class="text-right bolder nowrap">
                <span class="text-${e.type == 0 ? 'success' : 'danger'}">${e.type == 0 ? '+' : '-'} &#8358;${e.amount} </span>
                <span class="text-${e.type == 0 ? 'danger' : 'success'}">${e.type == 0 ? '-' : '+'} &#8358;${e.amount} </span>
                </td>
            </tr>
        `)
    }

    const fetchTransactions = async () => {
        try {
            let res = await fetch('/admin/transactions/transaction');
            let data = await res.json()
            transactions = data
            paginate(page, limit)
            controls()
        } catch (error) {
            console.log(error);
        }
    }

    function paginate(page, limit){
        page--;
        let start = limit * page;
        let end = start + limit;
        $('#transaction-item').html('')
        paginated = transactions.slice(start, end);
        paginated.forEach(transactionItem);
    }

    function controls(){
        let rows = Math.ceil(transactions.length / limit)
        if(rows > 0){
            $('.paginate-count').html('')
            for (let i = 1; i <= rows; i++) {
                $('.paginate-count').append(`
                    <li data-page="${i}" class="change-page ${i == page && 'active'}"><a href="javascript:void(0);">${i}</a></li>
                `)
            }
        }
    }

    $(document).on('click', '.change-page' ,function(){
        page = $(this).data('page')
        paginate(page, limit)
        controls()
    })

    fetchTransactions()
})