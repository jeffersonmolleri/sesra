function wineEdit(e)
{
	e.preventDefault();
	handleWine({ action: 'edit', name: $(this).attr('title'), id: $(this).attr('href').substr(1) });
}
function wineDelete(e)
{
	e.preventDefault();
	handleWine({ action: 'delete', id: $(this).attr('href').substr(1) });	
}
function wineUp(e)
{
	e.preventDefault();
	handleWine({ action: 'up', id: $(this).attr('href').substr(1) });
}
function wineDown(e)
{
	e.preventDefault();
	handleWine({ action: 'down', id: $(this).attr('href').substr(1) });
}

function handleWine(params)
{
	switch (params.action)
	{
		case 'up':
		case 'down':
			var action = params.action.charAt(0).toUpperCase() + params.action.slice(1).toLowerCase();
			$.get(env.concat('/wines/category' + action + '?_dc=' + new Date().getMilliseconds() + '&id=' + params.id), '');
			break;

		case 'edit':
			$('#category_id').val(params.id);
			$('#category_name').val(params.name);
			$('#category-header').addClass('edit').removeClass('add');
			break;
			
		case 'update':
			if ($('#category_name').val().length > 0)
			{
				$.post(env.concat('/wines/updateCategory'), {
					id: $('#category_id').val(),
					name: $('#category_name').val()
				});
				$('#category_id').val('');
				$('#category_name').val('');
				$('#category-header').addClass('add').removeClass('edit');
			}
			break;
			
		case 'delete':
			if (confirm('Ao REMOVER esta CATEGORIA você removerá os VINHOS relacionados, tem certeza que deseja remover?'))
			{
				$.get(env.concat('/wines/removeCategory?_dc=' + new Date().getMilliseconds() + '&id=' + params.id), '');
			}
			break;
	}
}