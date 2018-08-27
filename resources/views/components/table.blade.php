@if(isset($table) and is_array($table))
    <div class="table-responsive">
        <table class="table table-dark table-bordered table-striped">
            @if(isset($table['thead']))
                <thead class="thead-dark table-header">
                <tr>
                    @foreach($table['thead'] as $key => $th)
                        <th @if($loop->first)hidden @endif @if(!is_numeric($key)) class="ordenator">

                            @if($order['orderby'] == $key and $order['order'] == 'asc')
                                <a class="ordened" href="{{route($route.'.order',[$key,'desc'])}}">
                                    {{$th}}
                                    <i class="far fa-arrow-alt-circle-up"></i>
                                </a>
                            @elseif($order['orderby'] == $key and $order['order'] == 'desc')
                                <a class="ordened" href="{{route($route.'.order',[$key,'asc'])}}">
                                    {{$th}}
                                    <i class="far fa-arrow-alt-circle-down"></i>
                                </a>
                            @else
                                <a class="ordened" href="{{route($route.'.order',[$key,'asc'])}}">
                                    {{$th}}
                                    <span class="asc">
                                            <i class="far fa-arrow-alt-circle-down"></i>
                                    </span>
                                </a>
                            @endif
                            @else >
                            {{$th}}
                            @endif
                        </th>
                    @endforeach
                </tr>
                </thead>
            @endif
            <tbody class="table-body">
            @forelse($table['tbody'] as $tr)
                <tr>
                    @foreach($tr as $key => $cell)
                        @if(!is_array($cell))
                            <td @if($loop->first) hidden @endif  @if($key == 'telefone' || $key == 'cnpj')class="sem-quebra" @endif>
                                @if($loop->iteration == 2 and isset($route))
                                    <a class="featured" href="{{route($route.'.edit',[$tr['id']])}}">{{$cell}}</a>
                                    @if(isset($table['actions']))
                                        <div class="table-item-actions">
                                            @if(isset($table['actions']['edit']))
                                                <span class="edit">
                                                    <a href="{{route($route.'.edit',[$tr['id']])}}">{{$table['actions']['edit']}}</a>
                                                </span>
                                            @endif
                                            {{--<span class="edit"><a href="{{route($route.'.edit',[$tr['id']])}}">Eição Rápida</a></span> |--}}
                                            @if(isset($table['actions']['trash']))
                                                | <span class="trash"><a href="#"
                                                                         action="{{route($route.'.destroy2',[$tr['id']])}}">{{$table['actions']['trash']}}</a></span>
                                            @endif
                                            @if(isset($tr['modal']))
                                                | <span class="details"><a data-target="#table-modal-{{$tr['id']}}"
                                                                           href="#">Detalhes</a></span>
                                            @endif
                                        </div>
                                    @endif
                                @else
                                    {{$cell}}
                                @endif
                            </td>
                        @else

                            <div id="table-modal-{{$tr['id']}}" class="modal fade" tabindex="-1" role="dialog">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close"><span
                                                        aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title">{{$tr['modal']['title']}}</h4>
                                        </div>
                                        <div class="modal-body">
                                            @foreach($tr['modal']['data'] as $data)

                                                <p><b>{{$data['title']}}:</b></p>
                                                <div class="modal-table" count="{{count($data['thead'])-1}}">
                                                    <div class="mt-thead">
                                                        <div class="mt-row">
                                                            @foreach($data['thead'] as $mthead)
                                                                @if(!$loop->first)
                                                                    <div class="mt-col">
                                                                        {{$mthead}}
                                                                    </div>
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                    <div class="mt-tbody">
                                                        @foreach($data['tbody'] as $mtbody)
                                                            <div class="mt-row">
                                                                @foreach($mtbody as $mtbodycell)
                                                                    @if($loop->iteration == 2)
                                                                        <div class="mt-col">
                                                                            <a class="featured" href="{{route($data['route'].'.edit',[$tr['id']])}}">{{$mtbodycell}}</a>
                                                                        </div>
                                                                    @elseif(!$loop->first)
                                                                        <div class="mt-col">
                                                                        {{$mtbodycell}}
                                                                    </div>
                                                                    @endif
                                                                @endforeach

                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    <div class="mt-tfoot">
                                                        <div class="mt-row">
                                                            @if(isset($data['tfoot']))
                                                                @foreach($data['tfoot'] as $mtfoot)
                                                                    @if(!$loop->first)
                                                                        <div class="mt-col">
                                                                            {{$mtfoot}}
                                                                        </div>
                                                                    @endif
                                                                @endforeach
                                                            @else
                                                                @foreach($data['thead'] as $mthead)
                                                                    @if(!$loop->first)
                                                                        <span class="mt-col">
                                                                        {{$mthead}}
                                                                    </span>
                                                                    @endif
                                                                @endforeach
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>




                                                {{--                                                @forelse($data['tbody'] as $tbody)--}}
                                                {{--<p>--}}
                                                {{--<a href="{{route($data['route'].'.edit',array('id' => $tbody['id']))}}">{{$tbody['name']}}</a>--}}
                                                {{--</p>--}}
                                                {{--@empty--}}
                                                {{--<p>Nenhum funcionário está cadastrado com essa Empresa</p>--}}
                                                {{--@endforelse--}}
                                            @endforeach
                                        </div>
                                        <div class="modal-footer">
                                            <a class="btn btn-danger excluir" action="{{route($route.'.destroy2',[$tr['id']])}}" href="#">Excluir</a>
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Fechar
                                            </button>
                                        </div>
                                    </div><!-- /.modal-content -->
                                </div><!-- /.modal-dialog -->
                            </div><!-- /.modal -->
                        @endif
                    @endforeach
                </tr>
            @empty
                <tr>
                    <td>Nenhum registro encontrado!</td>
                </tr>
            @endforelse
            </tbody>
            @if(isset($table['tfoot']))
                <tfoot class="table-footer">
                <tr>
                    @foreach($table['tfoot'] as $key => $tf)
                        <th @if($loop->first)hidden @endif  @if(!is_numeric($key)) class="ordenator">
                            @if($order['orderby'] == $key and $order['order'] == 'asc')
                                <a class="ordened" href="{{route($route.'.order',[$key,'desc'])}}">
                                    {{$tf}}
                                    <i class="far fa-arrow-alt-circle-up"></i>
                                </a>
                            @elseif($order['orderby'] == $key and $order['order'] == 'desc')
                                <a class="ordened" href="{{route($route.'.order',[$key,'asc'])}}">
                                    {{$tf}}
                                    <i class="far fa-arrow-alt-circle-down"></i>
                                </a>
                            @else
                                <a class="ordened" href="{{route($route.'.order',[$key,'asc'])}}">
                                    {{$tf}}
                                    <span class="asc">
                                            <i class="far fa-arrow-alt-circle-down"></i>
                                    </span>
                                </a>
                            @endif
                            @else >
                            {{$tf}}
                            @endif


                        </th>
                    @endforeach
                </tr>
                </tfoot>
            @endif
        </table>
    </div>
    <script>
        function configPage() {
            $('.excluir').on('click', function () {
                // if (confirm('Tem certeza que deseja excluir esta empresa?\n\nQuando você exclui uma empresa, exclui também\ntodo seu histórico e itens vinculados a ela.')) {
                //     window.location = $(this).attr('action');
                // }
                if (confirm('Tem certeza que deseja excluir?')) {
                    window.location = $(this).attr('action');
                }
            });

            var width = parseInt($('.modal-table').attr('count'));
            width = 100/width;

            $('.modal-table .mt-col').css(
                'width', width+'%'
            );

            $('.table-item-actions .trash a').on('click', function () {
                if (confirm('Tem certeza que deseja excluir?')) {
                    window.location = $(this).attr('action');
                }
            });


            $('.details a').on('click', function () {
                $($(this).attr('data-target')).modal();
            });
        }
    </script>
@else
    <h4 class="not-found text-danger">Nenhum registro encontrado!</h4>
@endif

