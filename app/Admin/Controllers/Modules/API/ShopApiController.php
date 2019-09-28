<?php
#app/Http/Admin/Controllers/Modules/Api/ShopApiController.php
namespace App\Admin\Controllers\Modules\Api;

use App\Admin\Admin;
use App\Http\Controllers\Controller;
use App\Models\ShopApi;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ShopApiController extends Controller {
	use HasResourceActions;
	/**
	 * Index interface.
	 *
	 * @return Content
	 */
	public $apiType = ['private' => 'Private', 'secret' => 'Secret', 'public' => 'Public'];

	public function index(Content $content) {
		return $content
			->row('<span style="font-size:15px;font-style: italic;">(' . trans('api.guide') . ')</span><br>')
			->header(trans('api.manager'))
			->description(' ')
			->body($this->grid());
	}

	/**
	 * Edit interface.
	 *
	 * @param $id
	 * @return Content
	 */
	public function edit($id, Content $content) {
		return $content
			->header(trans('api.manager'))
			->description(' ')
			->body($this->form()->edit($id));
	}

	/**
	 * Create interface.
	 *
	 * @return Content
	 */
	public function create(Content $content) {
		return $content
			->header(trans('api.manager'))
			->description(' ')
			->body($this->form());
	}

	/**
	 * Make a grid builder.
	 *
	 * @return Grid
	 */
	protected function grid() {
		$arrApi = [
			'api_order_detail' => url('/') . '/api/order',
			'api_order_list' => url('/') . '/api/order',
			'api_product_detail' => url('/') . '/api/product',
			'api_product_list' => url('/') . '/api/product',
		];
		$grid = new Grid(new ShopApi);
		$grid->id('ID')->sortable();
		$grid->name(trans('api.name'))->sortable();
		$grid->hidden_default(trans('api.hidden_default'))->display(function ($field) {
			if ($field) {
				$html = '';
				$fields = explode(',', $field);
				foreach ($fields as $key => $value) {
					$html .= ' <span class="label label-primary">' . $value . '</span> ';
				}
				return $html;
			} else {
				return trans('api.no_hidden');
			}
		});
		$grid->html('URL')->display(function () use ($arrApi) {
			return $arrApi[$this->name];
		});
		$grid->secrets(trans('api.secret_key'))->expand(function () {
			$secrets = $this->secrets;
			$html = '';
			if ($secrets->count()) {
				$html .= '
            <table width="100%" class="table-padding" border=1 style="border: 1px solid #d0bcbc;"><tr>
            <td>' . trans('api.secret_key') . '</td>
            <td>' . trans('api.hidden_fileds') . '</td>
            <td>' . trans('api.ip_allow') . '</td>
            <td>' . trans('api.ip_deny') . '</td>
            <td>' . trans('api.created_at') . '</td>
            <td>' . trans('api.updated_at') . '</td>
            <td>' . trans('api.exp') . '</td>
            <td>' . trans('api.status') . '</td>
            </tr>';
				foreach ($secrets as $key => $secret) {
					$html_hidden_fileds = '';
					if ($secret['hidden_fileds']) {
						$fields = explode(',', $secret['hidden_fileds']);
						foreach ($fields as $key => $value) {
							$html_hidden_fileds .= ' <span class="label label-primary">' . $value . '</span> ';
						}
					}
					$html .= '<tr>
                    <td>' . $secret['secret_key'] . '</td>
                    <td>' . $html_hidden_fileds . '</td>
                    <td>' . (($secret['ip_allow']) ? str_replace(',', '<br>', $secret['ip_allow']) : '') . '</td>
                    <td>' . (($secret['ip_deny']) ? str_replace(',', '<br>', $secret['ip_deny']) : '') . '</td>
                    <td>' . $secret['created_at'] . '</td>
                    <td>' . $secret['updated_at'] . '</td>
                    <td>' . $secret['exp'] . '</td>
                    <td>' . (($secret['status']) ? '<span class="label label-primary">ON</span>' : '<span class="label label-warning">OFF</span>') . '</td>
                    </tr>';
				}
				$html .= "</table>";
			} else {
				$html .= '<p class="table-padding text-center">' . trans('api.no_secret') . '</p>';
			}
			return $html;
		}, trans('admin.detail'));

		$grid->type(trans('api.type'))->display(function ($type) {
			$style = "";
			if ($type == 'private') {
				$style = 'class="label label-primary"';
			} elseif ($type == 'public') {
				$style = 'class="label label-warning"';
			} elseif ($type == 'secret') {
				$style = 'class="label label-success"';
			}
			return "<span $style>" . $type . "</span>";
		});

		$grid->disableRowSelector();
		$grid->disableFilter();
		$grid->tools(function ($tools) {
			$tools->disableRefreshButton();
		});
		$grid->disableExport();
		$grid->actions(function ($actions) {
			$actions->disableView();
		});
		$grid->model()->orderBy('id', 'desc');
		return $grid;
	}

	/**
	 * Make a form builder.
	 *
	 * @return Form
	 */
	protected function form() {
		$form = new Form(new ShopApi);
		$form->text('name', trans('api.name'))->rules(function ($form) {
			return 'required|unique:shop_api,name,' . $form->model()->id . ',id';
		})->help(trans('api.name_help'));
		$form->text('hidden_default', trans('api.hidden_default'))->help(trans('api.hidden_default_help'));
		$form->select('type', trans('api.type'))->options($this->apiType)->help(trans('api.type_help'));
		$form->hasMany('secrets', trans('api.secret_key'), function (Form\NestedForm $form) {
			$form->text('secret_key', trans('api.secret_key'))->rules('required');
			$form->text('hidden_fileds', trans('api.hidden_fileds'));
			$form->text('ip_allow', trans('api.ip_allow'))->help(trans('api.ip_allow_help'));
			$form->text('ip_deny', trans('api.ip_deny'));
			$form->datetime('exp', trans('api.exp'));
			$form->switch('status', trans('api.status'));
		});
		$form->disableViewCheck();
		$form->disableEditingCheck();
		$form->tools(function (Form\Tools $tools) {
			$tools->disableView();
		});
		return $form;
	}

	/**
	 * Show interface.
	 *
	 * @param mixed $id
	 * @param Content $content
	 * @return Content
	 */
	public function show($id, Content $content) {
		return $content
			->header('Detail')
			->description(' ')
			->body($this->detail($id));
	}

	/**
	 * Make a show builder.
	 *
	 * @param mixed $id
	 * @return Show
	 */
	protected function detail($id) {
		$show = new Show(ShopApi::findOrFail($id));
		return $show;
	}

}
