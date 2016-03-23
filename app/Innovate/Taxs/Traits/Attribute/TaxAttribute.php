<?php

namespace Innovate\Taxs\Traits\Attribute;

use Illuminate\Support\Facades\Hash;

/**
 * Class UserAttribute
 * @package App\Models\Access\User\Traits\Attribute
 */
trait TaxAttribute
{
    /**
     * Hash the users password
     *
     * @param $value
     */
    public function setPasswordAttribute($value)
    {
        if (Hash::needsRehash($value)) {
            $this->attributes['password'] = bcrypt($value);
        } else {
            $this->attributes['password'] = $value;
        }

    }

    /**
     * @return string
     */
    public function getConfirmedLabelAttribute()
    {
        if ($this->confirmed == 1) {
            return "<label class='label label-success'>Yes</label>";
        }

        return "<label class='label label-danger'>No</label>";
    }

    /**
     * @return mixed
     */
    public function getPictureAttribute()
    {
        /**
         * If user is logged in with a social account, use the avatar associated if available
         * Otherwise fallback to the gravatar associated with the social email
         */
        if (session('socialite_provider')) {
            if ($avatar = $this->providers()->where('provider', session('socialite_provider'))->first()->avatar) {
                return $avatar;
            }
        }

        /**
         * Otherwise get the gravatar of the users email account
         */
        return gravatar()->get($this->email, ['size' => 50]);
    }

    /**
     * @return string
     */
    public function getEditButtonAttribute()
    {
        if (access()->can('edit-users')) {
            return '<a href="' . route('admin.tax.edit', $this->id) . '" class="btn btn-xs btn-primary"><i class="fa fa-pencil" data-toggle="tooltip" data-placement="top" title="' . trans('crud.edit_button') . '"></i></a> ';
        }

        return '';
    }

    /**
     * @return string
     */
    public function getChangePasswordButtonAttribute()
    {
        if (access()->can('change-user-password')) {
            return '<a href="' . route('admin.access.user.change-password', $this->id) . '" class="btn btn-xs btn-info"><i class="fa fa-refresh" data-toggle="tooltip" data-placement="top" title="' . trans('crud.change_password_button') . '"></i></a>';
        }

        return '';
    }

    /**
     * @return string
     */
    public function getStatusButtonAttribute()
    {
        switch ($this->status) {
            case 0:
                if (access()->can('reactivate-users')) {
                    return '<a href="' . route('admin.access.user.mark', [$this->id, 1]) . '" class="btn btn-xs btn-success"><i class="fa fa-play" data-toggle="tooltip" data-placement="top" title="' . trans('crud.activate_user_button') . '"></i></a> ';
                }

                break;

            case 1:
                $buttons = '';

                if (access()->can('deactivate-users')) {
                    $buttons .= '<a href="' . route('admin.access.user.mark', [$this->id, 0]) . '" class="btn btn-xs btn-warning"><i class="fa fa-pause" data-toggle="tooltip" data-placement="top" title="' . trans('crud.deactivate_user_button') . '"></i></a> ';
                }

                if (access()->can('ban-users')) {
                    $buttons .= '<a href="' . route('admin.access.user.mark', [$this->id, 2]) . '" class="btn btn-xs btn-danger"><i class="fa fa-times" data-toggle="tooltip" data-placement="top" title="' . trans('crud.ban_user_button') . '"></i></a> ';
                }

                return $buttons;
                break;

            case 2:
                if (access()->can('reactivate-users')) {
                    return '<a href="' . route('admin.access.user.mark', [$this->id, 1]) . '" class="btn btn-xs btn-success"><i class="fa fa-play" data-toggle="tooltip" data-placement="top" title="' . trans('crud.activate_user_button') . '"></i></a> ';
                }

                break;

            default:
                return '';
                break;
        }

        return '';
    }

    public function getConfirmedButtonAttribute()
    {
        if (!$this->confirmed) {
            if (access()->can('resend-user-confirmation-email')) {
                return '<a href="' . route('admin.account.confirm.resend', $this->id) . '" class="btn btn-xs btn-success"><i class="fa fa-refresh" data-toggle="tooltip" data-placement="top" title="Resend Confirmation E-mail"></i></a> ';
            }
        }

        return '';
    }

    /**
     * @return string
     */
    public function getDeleteButtonAttribute()
    {
        if (access()->can('view-innovate-ecommerce')) {
            return '<a href="' . route('admin.tax.destroy', $this->id) . '" data-method="delete" class="btn btn-xs btn-danger"><i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="' . trans('crud.delete_button') . '"></i></a>';
        }

        return '';
    }

    /**
     * @return string
     */
    public function getActionButtonsAttribute()
    {
        return $this->getEditButtonAttribute() .
        $this->getDeleteButtonAttribute();
    }
}
