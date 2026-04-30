@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        Edit Order
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('admin.orders.update', [$order->id]) }}">
            @method('PUT')
            @csrf

            <div class="form-group">
                <label for="invoice_number">Invoice Number</label>
                <input class="form-control {{ $errors->has('invoice_number') ? 'is-invalid' : '' }}" type="text" name="invoice_number" id="invoice_number" value="{{ old('invoice_number', $order->invoice_number) }}" required>
                @if($errors->has('invoice_number'))
                    <div class="invalid-feedback">
                        {{ $errors->first('invoice_number') }}
                    </div>
                @endif
            </div>

            <div class="form-group">
                <label for="user_id">User</label>
                <select class="form-control {{ $errors->has('user_id') ? 'is-invalid' : '' }}" name="user_id" id="user_id">
                    <option value="">Pilih User</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('user_id', $order->user_id) == $user->id ? 'selected' : '' }}>
                            {{ $user->name }} - {{ $user->email }}
                        </option>
                    @endforeach
                </select>
                @if($errors->has('user_id'))
                    <div class="invalid-feedback">
                        {{ $errors->first('user_id') }}
                    </div>
                @endif
            </div>

            <div class="form-group">
                <label for="package_id">Package</label>
                <select class="form-control {{ $errors->has('package_id') ? 'is-invalid' : '' }}" name="package_id" id="package_id">
                    <option value="">Pilih Package</option>
                    @foreach($packages as $package)
                        <option value="{{ $package->id }}" {{ old('package_id', $order->package_id) == $package->id ? 'selected' : '' }}>
                            {{ $package->name }}
                        </option>
                    @endforeach
                </select>
                @if($errors->has('package_id'))
                    <div class="invalid-feedback">
                        {{ $errors->first('package_id') }}
                    </div>
                @endif
            </div>

            <div class="form-group">
                <label for="order_type">Order Type</label>
                <select class="form-control {{ $errors->has('order_type') ? 'is-invalid' : '' }}" name="order_type" id="order_type" required>
                    @foreach($orderTypes as $key => $label)
                        <option value="{{ $key }}" {{ old('order_type', $order->order_type) === $key ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
                @if($errors->has('order_type'))
                    <div class="invalid-feedback">
                        {{ $errors->first('order_type') }}
                    </div>
                @endif
            </div>

            <hr>

            <div class="form-group">
                <label for="customer_name">Customer Name</label>
                <input class="form-control {{ $errors->has('customer_name') ? 'is-invalid' : '' }}" type="text" name="customer_name" id="customer_name" value="{{ old('customer_name', $order->customer_name) }}" required>
                @if($errors->has('customer_name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('customer_name') }}
                    </div>
                @endif
            </div>

            <div class="form-group">
                <label for="customer_phone">Customer Phone</label>
                <input class="form-control {{ $errors->has('customer_phone') ? 'is-invalid' : '' }}" type="text" name="customer_phone" id="customer_phone" value="{{ old('customer_phone', $order->customer_phone) }}" required>
                @if($errors->has('customer_phone'))
                    <div class="invalid-feedback">
                        {{ $errors->first('customer_phone') }}
                    </div>
                @endif
            </div>

            <div class="form-group">
                <label for="customer_email">Customer Email</label>
                <input class="form-control {{ $errors->has('customer_email') ? 'is-invalid' : '' }}" type="email" name="customer_email" id="customer_email" value="{{ old('customer_email', $order->customer_email) }}">
                @if($errors->has('customer_email'))
                    <div class="invalid-feedback">
                        {{ $errors->first('customer_email') }}
                    </div>
                @endif
            </div>

            <hr>

            <div class="form-group">
                <label for="event_date">Event Date</label>
                <input class="form-control {{ $errors->has('event_date') ? 'is-invalid' : '' }}" type="date" name="event_date" id="event_date" value="{{ old('event_date', $order->event_date ? $order->event_date->format('Y-m-d') : '') }}" required>
                @if($errors->has('event_date'))
                    <div class="invalid-feedback">
                        {{ $errors->first('event_date') }}
                    </div>
                @endif
            </div>

            <div class="form-group">
                <label for="event_location_name">Event Location Name</label>
                <input class="form-control {{ $errors->has('event_location_name') ? 'is-invalid' : '' }}" type="text" name="event_location_name" id="event_location_name" value="{{ old('event_location_name', $order->event_location_name) }}">
                @if($errors->has('event_location_name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('event_location_name') }}
                    </div>
                @endif
            </div>

            <div class="form-group">
                <label for="event_address">Event Address</label>
                <textarea class="form-control {{ $errors->has('event_address') ? 'is-invalid' : '' }}" name="event_address" id="event_address" rows="3">{{ old('event_address', $order->event_address) }}</textarea>
                @if($errors->has('event_address'))
                    <div class="invalid-feedback">
                        {{ $errors->first('event_address') }}
                    </div>
                @endif
            </div>

            <div class="form-group">
                <label for="event_latitude">Event Latitude</label>
                <input class="form-control {{ $errors->has('event_latitude') ? 'is-invalid' : '' }}" type="text" name="event_latitude" id="event_latitude" value="{{ old('event_latitude', $order->event_latitude) }}">
                @if($errors->has('event_latitude'))
                    <div class="invalid-feedback">
                        {{ $errors->first('event_latitude') }}
                    </div>
                @endif
            </div>

            <div class="form-group">
                <label for="event_longitude">Event Longitude</label>
                <input class="form-control {{ $errors->has('event_longitude') ? 'is-invalid' : '' }}" type="text" name="event_longitude" id="event_longitude" value="{{ old('event_longitude', $order->event_longitude) }}">
                @if($errors->has('event_longitude'))
                    <div class="invalid-feedback">
                        {{ $errors->first('event_longitude') }}
                    </div>
                @endif
            </div>

            <div class="form-group">
                <label for="distance_km">Distance KM</label>
                <input class="form-control {{ $errors->has('distance_km') ? 'is-invalid' : '' }}" type="number" step="0.01" name="distance_km" id="distance_km" value="{{ old('distance_km', $order->distance_km) }}">
                @if($errors->has('distance_km'))
                    <div class="invalid-feedback">
                        {{ $errors->first('distance_km') }}
                    </div>
                @endif
            </div>

            <div class="form-group">
                <label for="shipping_fee">Shipping Fee</label>
                <input class="form-control {{ $errors->has('shipping_fee') ? 'is-invalid' : '' }}" type="number" name="shipping_fee" id="shipping_fee" value="{{ old('shipping_fee', $order->shipping_fee) }}" min="0">
                @if($errors->has('shipping_fee'))
                    <div class="invalid-feedback">
                        {{ $errors->first('shipping_fee') }}
                    </div>
                @endif
            </div>

            <hr>

            <div class="form-group">
                <label for="subtotal_package">Subtotal Package</label>
                <input class="form-control {{ $errors->has('subtotal_package') ? 'is-invalid' : '' }}" type="number" name="subtotal_package" id="subtotal_package" value="{{ old('subtotal_package', $order->subtotal_package) }}" min="0">
                @if($errors->has('subtotal_package'))
                    <div class="invalid-feedback">
                        {{ $errors->first('subtotal_package') }}
                    </div>
                @endif
            </div>

            <div class="form-group">
                <label for="subtotal_custom">Subtotal Custom</label>
                <input class="form-control {{ $errors->has('subtotal_custom') ? 'is-invalid' : '' }}" type="number" name="subtotal_custom" id="subtotal_custom" value="{{ old('subtotal_custom', $order->subtotal_custom) }}" min="0">
                @if($errors->has('subtotal_custom'))
                    <div class="invalid-feedback">
                        {{ $errors->first('subtotal_custom') }}
                    </div>
                @endif
            </div>

            <div class="form-group">
                <label for="subtotal_addons">Subtotal Addons</label>
                <input class="form-control {{ $errors->has('subtotal_addons') ? 'is-invalid' : '' }}" type="number" name="subtotal_addons" id="subtotal_addons" value="{{ old('subtotal_addons', $order->subtotal_addons) }}" min="0">
                @if($errors->has('subtotal_addons'))
                    <div class="invalid-feedback">
                        {{ $errors->first('subtotal_addons') }}
                    </div>
                @endif
            </div>

            <div class="form-group">
                <label for="total_price">Total Price</label>
                <input class="form-control {{ $errors->has('total_price') ? 'is-invalid' : '' }}" type="number" name="total_price" id="total_price" value="{{ old('total_price', $order->total_price) }}" min="0">
                @if($errors->has('total_price'))
                    <div class="invalid-feedback">
                        {{ $errors->first('total_price') }}
                    </div>
                @endif
            </div>

            <hr>

            <div class="form-group">
                <label for="status">Status</label>
                <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status" id="status" required>
                    @foreach($statusOptions as $key => $label)
                        <option value="{{ $key }}" {{ old('status', $order->status) === $key ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
                @if($errors->has('status'))
                    <div class="invalid-feedback">
                        {{ $errors->first('status') }}
                    </div>
                @endif
            </div>

            <div class="form-group">
                <label for="payment_status">Payment Status</label>
                <select class="form-control {{ $errors->has('payment_status') ? 'is-invalid' : '' }}" name="payment_status" id="payment_status" required>
                    @foreach($paymentStatusOptions as $key => $label)
                        <option value="{{ $key }}" {{ old('payment_status', $order->payment_status) === $key ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
                @if($errors->has('payment_status'))
                    <div class="invalid-feedback">
                        {{ $errors->first('payment_status') }}
                    </div>
                @endif
            </div>

            @php
                $datetimeFields = [
                    'payment_deadline' => 'Payment Deadline',
                    'paid_at' => 'Paid At',
                    'confirmed_at' => 'Confirmed At',
                    'invoice_sent_at' => 'Invoice Sent At',
                    'processed_at' => 'Processed At',
                    'completed_at' => 'Completed At',
                    'cancelled_at' => 'Cancelled At',
                ];
            @endphp

            @foreach($datetimeFields as $field => $label)
                <div class="form-group">
                    <label for="{{ $field }}">{{ $label }}</label>
                    <input
                        class="form-control {{ $errors->has($field) ? 'is-invalid' : '' }}"
                        type="datetime-local"
                        name="{{ $field }}"
                        id="{{ $field }}"
                        value="{{ old($field, $order->{$field} ? $order->{$field}->format('Y-m-d\TH:i') : '') }}"
                    >
                    @if($errors->has($field))
                        <div class="invalid-feedback">
                            {{ $errors->first($field) }}
                        </div>
                    @endif
                </div>
            @endforeach

            <div class="form-group">
                <label for="cancelled_reason">Cancelled Reason</label>
                <textarea class="form-control {{ $errors->has('cancelled_reason') ? 'is-invalid' : '' }}" name="cancelled_reason" id="cancelled_reason" rows="3">{{ old('cancelled_reason', $order->cancelled_reason) }}</textarea>
                @if($errors->has('cancelled_reason'))
                    <div class="invalid-feedback">
                        {{ $errors->first('cancelled_reason') }}
                    </div>
                @endif
            </div>

            <div class="form-group">
                <label for="notes">Notes</label>
                <textarea class="form-control {{ $errors->has('notes') ? 'is-invalid' : '' }}" name="notes" id="notes" rows="3">{{ old('notes', $order->notes) }}</textarea>
                @if($errors->has('notes'))
                    <div class="invalid-feedback">
                        {{ $errors->first('notes') }}
                    </div>
                @endif
            </div>

            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    Save
                </button>

                <a class="btn btn-default" href="{{ route('admin.orders.index') }}">
                    Back to list
                </a>
            </div>
        </form>
    </div>
</div>

@endsection