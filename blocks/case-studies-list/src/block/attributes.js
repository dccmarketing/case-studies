const attributes = {
	categories: {
		type: 'string',
	},
	order: {
		type: 'string',
		default: 'desc',
	},
	orderBy: {
		type: 'string',
		default: 'date',
	},
	perPage: {
		type: 'number',
		default: 10,
	},
};

export default attributes;
