# using-google-search-too-evaluate-neflix-videos
구글 검색을 이용한 넷플릭스 동영상 평가 시스템

**구글 검색을 이용한 넷플릭스 동영상 평가 시스템**

**프로젝트 제목: 구글 검색을 이용한 넷플릭스 동영상 평가 시스템 (GNE google neflix evaluation system)**

# I. 개발 목표

넷플릭스를 이용하는 시청자들에게 요즘은 볼 영상이 없다는 말을 자주 들었습니다. 그 이유는 넷플릭스 동영상은 정량적인 평가 기준이 없습니다. 이는 넷플릭스 자체에서 동영상의 순위를 매기는 방식이 아닌 머신러닝을 활용해 개인별로 적합한 영상을 추천해주는 방식이라서 정량적으로 얼마나 인기가 많은 영상인지는 광고에서 자주 나오는 영상을 통해서만 알 수 있거나, 검색을 해서 개별 블로그의 글들을 확인해야 합니다. 그래서 전 블로그에서 많이 추천해주는 리뷰가 작성된 영상이 재밌고 인가가 높은 영상이라는 점에 착안해 구글 검색을 통해 작성된 블로그의 수를 확인하고 이를 점수로 매기는 크롤링 시스템을 구현하였습니다.

이를 통해서 많은 영상을 스크롤 하면서 고민만 하지 않고 다른 사람들이 재밌다고 한 영상을 빠르게 찾아 확인하고 즐길 수 있는 시스템을 구현하고자 했습니다.

빌보드 랭킹 형식이 아닌 피자가게 메뉴판 같은 넷플릭스의 프론트. 어딜 가도 랭킹처럼 점수와 리스트는 없습니다.

# II. 개발 범위 및 내용

## 가. 개발 범위

입력한 영상에 대한 평가를 하고 이를 사용자에게 보여준다. 현재 평가된 항목들에 대해서도 리스트(넷보드)를 볼 수 있는 기능을 추가한다.

## 나. 개발 내용

영상의 제목을 입력받는 html 파일, 입력 받은 영상을 구글에서 크롤링 해줄 php파일, 평가된 항목을 저장하는 mysql db.

[##_Image|kage@cW68Bv/btqADZ6AuGh/SMiefIkOTfG3ezlp57yLN1/img.png|alignCenter|data-origin-width="602" data-origin-height="278"|||_##]

# III. 추진 일정 및 개발 방법

## 가. 추진 일정

12/15 ~12/17 : 어떻게 하면 넷플릭스 영상을 평가 할 수 있을지 구상하였습니다. 그리고 개발 한계점을 조사했습니다.

12/17~12/20 : html을 통해 제목 입력 받고php 를 통한 크롤링 구현, 구글 검색 get 요청 url 분석 그리고 이에 맞게 수정해서 입력하는 php 파일 구현. DOM 파서를 이용해서 DOM 구조에서 원하는 검색 값인 “비디오 제목” 그리고 “넷플릭스 추천” 두 단어를 포함한 블로그가 몇개인지 검색하는 과정 구현

12/ 21 ~12/22 : 항목들 디비에 저장, 구글에서 크롤링 금지하는 사실을 발견 ( 너무 자주 요청을 보내면 안됩니다.....ip를 변경하는 전략 사용이 어려우므로).

12/23 : 보고서 작성

## 나. 개발 방법

수업 시간에 배운 html form 입력 ,php file\_get\_html 이용 , DOM 트리 구조를 통해 원하는 결과값 검색

# IV. 연구 결과

## 가. 합성 내용

[##_Image|kage@dp4nAt/btqACF9hg1n/NJqkZ7Bp6K9xPAEYWHxSZ1/img.png|alignCenter|data-origin-width="0" data-origin-height="0"|||_##]

action\_WebCrawler.html : 영상 제목 입력 받음

WebCrawler.php : 해당 영상을 검색해서 평가함, 제목과 점수를 mysql로 넘김

## 나. 개발 방법

1. html php 연동 방식 : POST를 통해 넘겨주고 ,utf-8을 기본 인코딩으로 설정 하였습니다.

2. 크롤링 방법 :

[##_Image|kage@VeDk9/btqADi6EiVo/RO9XK64Sqxplrvy2tfCXpk/img.png|alignCenter|data-origin-width="0" data-origin-height="0"|||_##]

이 부분이 시간이 오래 걸렸습니다. [https://www.google.com/search?q=](https://www.google.com/search?q=)에 원하는 영상 제목을 더해서 검색하면 구글에 요청이 들어 갑니다.

가령 킹덤을 넷플릭스 추천이라는 검색어와 구글 검색 방법중 and 검색(즉 두개다 모두 포함하는 검색어를 검색한다.)하면 이렇게 입력하면 됩니다.

[https://www.google.com/search?q=%EB%84%B7%ED%94%8C%EB%A6%AD%EC%8A%A4+and+%EC%B6%94%EC%B2%9C+%ED%82%B9%EB%8D%A4](https://www.google.com/search?q=%EB%84%B7%ED%94%8C%EB%A6%AD%EC%8A%A4+and+%EC%B6%94%EC%B2%9C+%ED%82%B9%EB%8D%A4)

[https://www.google.com/search?q=](https://www.google.com/search?q=)넷플릭스+추천+and+킹덤

이때 이를 위해서 아래의 값을 urlencode()를 사용해 url 값으로 변경 시켜서 요청해야 합니다. 이는 영어의 경우 상관 없지만 영어 이외의 문자는 이렇게 하는 것이 표준입니다.

그리고 저는

[##_Image|kage@cBOEfH/btqAE6Eaxo9/rJH8fA9PDu1IG1pKi8CDd0/img.png|alignCenter|data-origin-width="0" data-origin-height="0"|||_##]

이렇게 페이지를 넘어가면서 “넷플릭스 추천” 그리고 “ 킹덤” 이라는 두 항목이 아래 DOM 클래스에 반드시 같이 있는 항목의 갯수를 카운트 하였습니다.

[##_Image|kage@bpHcYi/btqAB3P5MQC/iRCYsBqfwynNQdLCFBXLxK/img.png|alignCenter|data-origin-width="0" data-origin-height="0"|||_##]

크롬 개발자 도구를 이용한 경험 적인 분석을 통해 class = BNeawe vvjwJb AP7Wnd 아래에 두 검색어가 모두 있는 경우만이 저희가 찾고자 하는 블로그에서 작성한 추천 글임이 95프로 이상 확실했습니다.

페이지를 넘어가는 url은 [https://www.google.com/search?q=](https://www.google.com/search?q=)넷플릭스+추천+and+킹덤&start=10

으로 &start=10 을 추가했습니다. 다음 페이지는 20, 10씩 증가함.

## 나. 한계점

1. 크롤링이 금지되어있는 구글 : 구글 robot.txt에 들어가보니 /search 아래 경로에 대한 크롤링은 금지되어 있었습니다. 그래서 몇번 자주 사용하니 약 3시간 가량 요청을 무시하는 결과가 발견되었습니다. php file\_get\_html은 그 이하의 코드를 중지해 버렸습니다. (에러 체크가 어려운php의 문제도 있음). 즉 짧은 시간동안 여러번 해당 시스템을 사용하는 것은 어렵습니다. 그래서 mysql 디비를 추가해서 한번 검색한 항목은 다시 검색하지 않도록 하였습니다.

2. 넷플릭스에는 너무 많은 영화 드라마 항목이 있고 넷플릭스 오리지널(넷플릭스 자체 제작 드라마와 영화)에 대한 리스트만이 웹사이트와 넷플릭스를 통해 확인할 수 있고, 모든 전체 영화 드라마에 대한 리스트는 찾지 못하였습니다. 그래서 빌보드처럼 랭킹을 만드는 넷보드는 시간이 좀 더 필요할 것으로 예상되어 나중으로 미루게 되었습니다.

## 다. 시험 내용

구축한 시스템에 기반한 평가 점수

1\. 킹덤 : 89점

2\. 나를 찾아줘: 51점

3\. 위처 : 48점

4\. 블랙 미러 :94점

5\. 브레이킹 배드: 83점

6\. 기묘한 이야기: 94점

예시 화면

왓챠에서 검색한 별점 갯수

1\. 킹덤 : 3.6점

2\. 나를 찾아줘: 3.9점

3\. 위처 : 3.6점

4\. 블랙 미러 : 4.0점

5\. 브레이킹 배드: 4.3점

6\. 기묘한 이야기: 4.2점

## 마. 평가 내용

 이전에 정량적인 랭킹이 없어서 정량적인 비교가 어렵지만 , 블로거들이 직접 보고 작성한 블로그의 갯수를 기반으로 평가했으므로 어느정도 정확도가 높다고 판단됩니다. 그리고 실제로 평가 결과 왓챠에서 평가가 높을 수록 제가 구현한 시스템에서도 점수가 높으므로 정확성 또한 높다고 생각됩니다.

# V. 기타

## 가. 자체 평가

평가 정확도에 있어서는 만족스러웠습니다.

## 나. 어려웠던점

1. 한글 입력과 한글 처리를 위주로 해서 인코딩에 대한 이해가 필요했습니다. php에서 알 수 없는 에러로 인코딩을 파악하고 변환하는데 24시간정도 고민했습니다. 결과적으로 막혔던 부분은 url 인코딩을 하지 않았던 부분이었습니다만 php에서 한글 입력시 조금 이상한 hex값을 출력하는 에러를 발견하였습니다.

구체적인 php 에러 부분

Concat 시킨  값과 "[https://www.google.com/search?q=](https://www.google.com/search?q=)기묘한+이야기" 통짜로  입력한  값이  다르다.

즉 $name = “기묘한+이야기”

$addr = “[https://www.google.com/search?q=](https://www.google.com/search?q=)[”](https://www.google.com/search?q=”%20) .$name과

$addr = "[https://www.google.com/search?q=](https://www.google.com/search?q=)기묘한+이야기" 이  두  값이  다릅니다.

bin2hex를 통해 확인한 값입니다.

[##_Image|kage@dzJaSx/btqAE7C4CMD/OKNC3V4OLKCET8aXWxrle0/img.png|alignCenter|data-origin-width="0" data-origin-height="0"|||_##]

왜 다른지는 아직도 모르겠지만 $name = urlencode($name); 을 통해서 성공했습니다.

2\. 구글이 클롤링을 허용하지 않습니다.... php라서 ip 변경 기술 같은것을 찾아 고치기에는 시간이 부족해서 그 정도로는 못했습니다. 다만 테스는 정상적으로 작동했습니다. 횟수를 너무 자주 안하면 됩니다.크롤링 차단으로 실패하면 화면이 빈화면이 뜹니다. file\_get\_html에서 php가 작동이 멈춥니다.

## 다. 추후 구현

영화 목록 전체를 구하지 못한점, 그리고 크롤링을 너무 자주 시도할 수 없어서 많은 항목을 확인해보기 어려운 점 때문에 아직 리스트를 구현하지 못했습니다. 빌보드 같은 넷보드를 만들고 .0~5별점 기준이아닌 0~100점으로 평가 점수를 좀 더 세분화 해서 왓챠와 같은 영화 리뷰 플랫폼을 구현하고자 합니다.
