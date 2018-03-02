@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                    <h3>重新導向中，請勿關閉本視窗</h3>

                    <div class="panel-body">
                        <form class="form-horizontal" method="POST" action="{{ $postTo }}">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="payWith" class="col-md-4 control-label">付款方式</label>

                                <div class="col-md-6">
                                    <select name="payWith" id="payWith" class="form-control">
                                        <option value="creditcard">信用卡</option>
                                    </select>
                                    @if ($errors->has('payWith'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('payWith') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="numbers" class="col-md-4 control-label">點數數量</label>

                                <div class="col-md-6">

                                    <select id="numbers" class="form-control" name="numbers">
                                        <option value="300">300</option>
                                        <option value="500">500</option>
                                        <option value="1000">1000</option>
                                        <option value="2000">2000</option>
                                        <option value="3000">3000</option>
                                        <option value="5000">5000</option>
                                        <option value="10000">10000</option>
                                        <option value="20000">20000</option>
                                    </select>

                                    @if ($errors->has('numbers'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('numbers') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-8 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        付款
                                    </button>

                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        取消
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
