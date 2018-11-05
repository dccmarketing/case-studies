const { __ } = wp.i18n;
const { Toolbar } = wp.components;
const { BlockControls } = wp.editor;

const Controls = ( { listLayout, setAttributes } ) => {
	const layoutControls = [
		{
			icon: 'list-view',
			title: __( 'List View' ),
			onClick: () => setAttributes( { listLayout: 'list' } ),
			isActive: listLayout === 'list',
		},
		{
			icon: 'grid-view',
			title: __( 'Grid View' ),
			onClick: () => setAttributes( { listLayout: 'grid' } ),
			isActive: listLayout === 'grid',
		},
	];
	return (
		<BlockControls>
			<Toolbar controls={ layoutControls } />
		</BlockControls>
	);
};

export default Controls;
