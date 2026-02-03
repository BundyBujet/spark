<div id="ajax_search_table">
    @if (@isset($admins) && count($admins) > 0)
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{ __('site.Name') }}</th>
                    <th>{{ __('site.Username') }}</th>
                    <th>{{ __('site.Status') }}</th>
                    <th>{{ __('site.Phone') }}</th>
                    <th>{{ __('site.More') }}</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $i = 1;
                @endphp
                @foreach ($admins as $admin)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>
                            {{ $admin->name }}
                            @if (auth()->user()->id == $admin->id)
                                <span class="badge bg-gray"> أنت</span>
                            @endif
                        </td>
                        <td> {{ $admin->username }}</td>
                        <td>
                            @if ($admin->status == 1)
                                <span class="badge bg-success">{{ __('site.Active') }}</span>
                            @else
                                <span class="badge bg-danger">معطل{{ __('site.InActive') }}</span>
                            @endif
                        </td>
                        <td>{{ $admin->phone ?? 'ـــــــــ' }}</td>

                        <td class="text-center d-flex">
                            @can('Edit Admin')
                                <a href="{{ route('admins.edit', $admin->id) }}" class="btn btn-sm btn-info me-2">
                                    <i class="fa fa-edit"></i> {{ __('site.Edit') }}
                                </a>
                            @endcan
                            @can('Delete Admin')
                                @if (auth()->user()->id !== $admin->id)
                                    <form id="user-delete-{{ $admin->id }}"
                                        action="{{ route('admins.destroy', $admin->id) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger sa-delete me-2">
                                            <i class="fa fa-trash"></i> {{ __('site.Delete') }}
                                        </button>
                                    </form>
                                @endif
                            @endcan
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <br />
        <div class="col-md-12" id="ajax_pagination_in_search">
            {{ $admins->links() }}
        </div>
    @else
        <div class="alert alert-danger">
            {{ __('site.NoDataFound') }}

        </div>
    @endif
</div>
