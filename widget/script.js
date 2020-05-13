define(['jquery'], function($){
    var CustomWidget	= function () {
    	var self	= this;
	
		this.get_ccard_info	= function () //Сбор информации из карточки контакта
		{
			if (self.system().area == 'ccard') {
				var phones		= $('.card-cf-table-main-entity .phone_wrapper input[type=text]:visible'),
                    c_phones	= [],
                for (var i = 0; i < phones.length; i++) {
					if ($(phones[i]).val().length > 0) {
						c_phones[i]	= $(phones[i]).val();
						}
					}
				console.log(c_phones);
				return c_phones;
				} else {
					return false;
					}
			};

		this.createLinkList	= function () //Создание списка ссылок на месседжеры
		{
			let contacts	= self.contacts;
			if (Array.isArray(contacts)) {
				if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
					// код для мобильных устройств
					let is_mobDev	= true;
					} else {
						// код для обычных устройств
						let is_mobDev	= false;
						}				
				let menu	= '<div>';
				let w_code = self.get_settings().widget_code;
				for (var contact in contacts) {
					menu	= menu+'<div><img src="/widgets/'+w_code+'/images/WhatsApp.png"><a href="https://wa.me/"'+contact+'>WhatsApp для '+contact+'</a>/<div>';
					menu	= menu+'<div><img src="/widgets/'+w_code+'/images/Telegram.png"><a href="t.me/"'+contact+'>Telegram для '+contact+'</a>/<div>';
					if (is_mobDev) {
						menu	= menu+'<div><img src="/widgets/'+w_code+'/images/Viber.png"><a href="viber://add?number='+contact+'">Viber для '+contact+'</a>/<div>';
						}
						else {
							menu	= menu+'<div><img src="/widgets/'+w_code+'/images/Viber.png"><a href="viber://chat?number='+contact+'">Viber для '+contact+'</a>/<div>';
							}
					menu	= menu+'<div><img src="/widgets/'+w_code+'/images/WeChat.png.png"><a href="weixin://dl/chat?"'+contact+'>WeChat для '+contact+'</a>/<div>';
					}
				menu	= menu+'/<div>';
				return menu;
				}
				else return '';
			};
        			
		this.callbacks = {
			render: function(){
				console.log('render');
                if (typeof (AMOCRM.data.current_card) != 'undefined') {
                    if (AMOCRM.data.current_card.id == 0) {
                        return false;
                    } // не рендерить на contacts/add || leads/add
                }
                self.render_template({
                    caption: {
                        class_name: 'js-ac-caption',
                        html: ''
                    },
                    body: '',
                    render: self.createLinkList()
                });				
				return true;
			},
			init: function(){
				console.log('init');

				AMOCRM.addNotificationCallback('widget_code', function (data) {
					console.log(data)
				});

                if (self.system().area == 'ccard') {
                    self.contacts = self.get_ccard_info();
                }

				return true;
			},
			bind_actions: function(){
				console.log('bind_actions');
				return true;
			},
			settings: function(){
				return true;
			},
			onSave: function(){
				alert('click');
				return true;
			},
			destroy: function(){
				
			},
			contacts: {
					//select contacts in list and clicked on widget name
					selected: function(){
						console.log('contacts');
					}
				},
			leads: {
					//select leads in list and clicked on widget name
					selected: function(){
						console.log('leads');
					}
				},
			tasks: {
					//select taks in list and clicked on widget name
					selected: function(){
						console.log('tasks');
					}
				}
		};
		return this;
    };

return CustomWidget;
});
