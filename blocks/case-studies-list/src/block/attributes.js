const attributes = {
	categories: {
		type: 'string',
	},
	listLayout: {
		type: 'string',
		default: 'list',
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
	showLogo: {
		type: 'boolean',
		default: false,
	},
};

export default attributes;
