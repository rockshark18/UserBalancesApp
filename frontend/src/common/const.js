// sort
const Const = {
	TRANSACTION_SORT :{
		ID: 'id',
		TYPE: 'type',
		AMOUNT: 'amount',
		DESC: 'desc',
		DATE: 'date',
	},

// transaction type
	TRANSACTION_TYPE : {
		INCOME: 'Income',
		EXPENSE: 'Expense',
	},

	SORT :{
		ASC: 1,
		DESC: -1,
	},

	HOME_PAGE_TRANSACTIONS_LIMIT:20, // NOTE: null = all

	AUTO_REFRESH_MS: 5000,
}

export default Const;
