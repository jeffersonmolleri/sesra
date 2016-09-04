function menuEdit(e)
{
	e.preventDefault();
	handleCategory({ action: 'edit', name: $(this).attr('title'), id: $(this).attr('href').substr(1) });
}
function menuDelete(e)
{
	e.preventDefault();
	handleCategory({ action: 'delete', id: $(this).attr('href').substr(1) });	
}
function menuUp(e)
{
	e.preventDefault();
	handleCategory({ action: 'up', id: $(this).attr('href').substr(1) });
}
function menuDown(e)
{
	e.preventDefault();
	handleCategory({ action: 'down', id: $(this).attr('href').substr(1) });
}

function handleCategory(params)
{
	switch (params.action)
	{
		case 'up':
		case 'down':
			var action = params.action.charAt(0).toUpperCase() + params.action.slice(1).toLowerCase();
			$.get(env.concat('/menu/category' + action + '?_dc=' + new Date().getMilliseconds() + '&id=' + params.id), '');
			break;

		case 'edit':
			$('#category_id').val(params.id);
			$('#category_name').val(params.name);
			$('#category-header').addClass('edit').removeClass('add');
			break;
			
		case 'update':
			if ($('#category_name').val().length > 0)
			{
				$.post(env.concat('/menu/updateCategory'), {
					id: $('#category_id').val(),
					name: $('#category_name').val()
				});
				$('#category_id').val('');
				$('#category_name').val('');
				$('#category-header').addClass('add').removeClass('edit');
			}
			break;
			
		case 'delete':
			if (confirm('Ao REMOVER esta CATEGORIA você removerá as OPÇÕES relacionadas, tem certeza que deseja remover?'))
			{
				$.get(env.concat('/menu/removeCategory?_dc=' + new Date().getMilliseconds() + '&id=' + params.id), '');
			}
			break;
	}
}