<script setup>
import photo from '@/assets/images/about/photo.jpg';
</script>

<template>
  <Debug/>
  <Navbar/>

  <div class="container">
  <div class="content">
    <div class="row py-3 py-lg-5">
      <div class="col-12 col-lg-8 text">
        <p>
          Привет! Меня зовут Алексей :)
        </p>
        <p>
          В Web-разработке я 4.5 года <br> Всего общий стаж разработки <b>24 года</b> (ещё со школы, в основном это был С/С++, 3d движки, OpenGL, шейдеры, игровая 3d-физика и т.д.)
        </p>
        <p>
          В Web-development чувствую себя относительно уверенно - PHP 7/8, JS, Laravel, Symfony, RestAPI/JWT, Vue 2/3, SCSS, Docker/docker-compose.
        </p>
        <p>
          Прошлый внушительный background только помогает, опыт по проектированию/архитектуре ПО, паттернам прокетирования, UML идёт только в плюс.
        </p>
        <p>
          В общем не новичёк - код стараюсь писать грамотно, если своими словами то:
        </p>
        <ul>
          <li>стараюсь не плодиить лишние сущности/классы, ненужные слои/уровни абстракции там где не планируется полиморфное поведение по общему интерфейсому или расширение функционала</li>
          <li>не «перегружаю» классы лишними обязанностиями делая из них «швейцарский-нож»</li>
          <li>инкапсуляцию сущностей стараюсь не нарушать</li>
          <li>минимизирую количество связей/зависимостей между сущностями, что бы код не превращался со временем в запутанный клубок.</li>
          <li>придерживаюсь минимализма и принципа минимальной достаточности в коде.</li>
        </ul>
        <p>
          Как-то так
        </p>
        <br>
        <p>
          Я чисто кодер/инженер, управляющие должности типа team-lead не потяну и не рассматриваю (ну может когда нибудь, в перспективе) <br> В общем хочу в хорошую команду, кодить с вами :)
        </p>
        Мой Telegram: <a href="https://t.me/alex_dev_256" target="_blank"><u>https://t.me/alex_dev_256</u></a>

      </div>
      <div class="col-12 col-lg-4 py-3 text-center">
        <img class="" :src="photo"/>
      </div>
    </div>
  </div>
  </div>

  <Footer/>
</template>

<script>
	// vue components
	import Navbar from "@/components/common/Navbar.vue";
	import Footer from "@/components/common/Footer.vue";
  import Debug from "../components/common/Debug.vue";

	export default {
		components: {
      Debug,
			Footer,
			Navbar,
		},
	}
</script>

<style lang="scss" scoped>
.content {
  background-color: $primary-background-color;
  min-height: 512px;
}

.text {
  font-family: $primary-font;
  font-weight: 500;
  font-size: 16px;
  line-height: 22px;
}

p {
  margin-bottom: 10px;
}

li {
  list-style-type: disc;
  margin-left: 20px;
  margin-bottom: 6px;
}

@media (min-width: 0px) { // XS+
  .text {
    font-size: 14px;
    line-height: 20px;
  }
}


@media (min-width: 768px) { // MD+
  .text {
    font-size: 16px;
    line-height: 22px;
  }
}

@media (min-width: 1200px) { // XL+
}


</style>
