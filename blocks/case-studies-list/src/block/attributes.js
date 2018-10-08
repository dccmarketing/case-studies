const attributes = {
	perPage: {
		type: 'number',
		default: 10,
	},
	order: {
		type: 'string',
		default: 'desc',
	},
	orderBy: {
		type: 'string',
		default: 'date',
	},
};

export default attributes;
