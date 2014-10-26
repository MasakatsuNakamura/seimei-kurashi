<?php 
// 陰陽五行の法則による運勢、健康運
// 判定結果は、シリアル番号順に並んでいる。
// 天画、人画、地画それぞれの下一桁をそれぞれ$t,$j,$cとした場合、次の式
// からシリアル番号を算出する。
// f($t) * 25 + f($j) *5 + f($c)
// ただし、
// f($x) = $xを２で割り、端数を切り上げ、結果が0だった場合5にしたものか
//         ら、1を引いたもの
// 上の数値を$iとした場合、$kenkou[$i]に結果が入る。
Class Kenkou
{
	public $mongon;
	
	public function Kenkou() {
		$this->mongon = Array (
			// 1/2、1/2、1/2の場合
			["木・木・木", "△", "「健康に恵まれます。抜群の能力や才能を発揮し、特殊な発展をします。<br>芸能人やスポーツ選手など、あまり一般的でない職業に向いています。<br>ただ、異性問題や愛情面に不安定さや支障を生じやすいのでご注意ください。」"],
			// 2/2、1/2、3/4の場合
			["木・木・火", "◎", "「健康に恵まれます。境遇は安泰で、順調に発展し、目的を成就します。運気旺盛で成功、発展します。」"],
			// 1/2、1/2、5/6の場合
			["木・木・土", "◎", "「健康に恵まれます。確固不動の安泰、平静和順で目的成就する。」"],
			# 1/2、1/2、7/8の場合
			["木・木・金", "×", "「精神不安定、気苦労多く、目的不伸、希望伸び悩む。<br>神経障害、胃腸疾患、年令により腎臓病、肝臓病を生じる。」"],
			# 1/2、1/2、9/0の場合
			["木・木・水", "×", "「一時の発展はあるが長続きせず、次第に不調和を来たし事が上手く回らなくなる。<br>凶数と重なると、不和を招いたり、冷え症を生じる。」"],
			# 1/2、3/4、1/2の場合
			["木・火・木", "◎", "「健康に恵まれます。発展向上運強く、境遇安泰、目下の支援を得て希望がかなう。」"],
			# 1/2、3/4、3/4の場合
			["木・火・火", "△", "「健康には恵まれますが、急進的、感情的になり易く、時に不和による不幸を招く事がある。<br>但し、主運・基礎運の吉数により緩和されることもある。」"],
			# 1/2、3/4、5/6の場合
			["木・火・土", "◎", "「健康に恵まれます。調和と融合による吉兆を得て、不穏安泰で万事順調に着実に発展する。」"],
			# 1/2、3/4、7/8の場合
			["木・火・金", "×", "「対立反発の意を生じて不安定を来たし、急禍急変の暗示が強く、神経障害、難病など生じやすい。<br>また数によってはノイローゼによる家庭不和をきたすこともある。」"],
			# 1/2、3/4、9/0の場合
			["木・火・水", "×", "「急禍を生じ凶数と相俟って病弱、悲業、災厄が重ね来る。家庭不和など逆境の暗示あり。」"],
			# 1/2、5/6、1/2の場合
			["木・土・木", "×", "「不伸気苦労多く、希望達成せず。時に神経系の病、胃腸疾患などを生じる。」"],
			# 1/2、5/6、3/4の場合
			["木・土・火", "○", "「健康に恵まれます。互いに調和融合する吉兆を得て、健全発展、目下の支援を受けて着実に発展する。<br>但し、主運に凶数があると、不信希望伸び悩み、中成功に留まる事もある。」"],
			# 1/2、5/6、5/6の場合
			["木・土・土", "○", "「健康には恵まれますが、平穏すぎて進取の気性が乏しく、希望伸び悩み、中成功に止まる。」"],
			# 1/2、5/6、7/8の場合
			["木・土・金", "○", "「健康に恵まれます。互いに調和融合する吉兆を得て発展する。内心強固で外面温和な人柄で人望厚く成功運が強い。<br>但し、主運に凶数があると、不信希望伸び悩み、中成功に留まる事もある。」"],
			# 1/2、5/6、9/0の場合
			["木・土・水", "×", "「意のままにならず次第に事が上手く回らなくなる。時に神経系の病、冷え症などを生じる。<br>+t主運に26画を持つあなたは、家庭不和を生じ易いので注意が必要です。-t」"],
			# 1/2、7/8、1/2の場合
			["木・金・木", "×", "「外見は良く見えても、内心は気苦労多く不伸・不安をのがれず。<br>腹部の病は必ず発する。晩年、時に肝臓、肝硬変などの暗示あり。」"],
			# 1/2、7/8、3/4の場合
			["木・金・火", "×", "「急禍急変の災厄あり。時に心臓マヒ、神経障害、ノイローゼの暗示あり。」"],
			# 1/2、7/8、5/6の場合
			["木・金・土", "△", "「互いに調和融合する吉兆を得て発展する。境遇安泰なり。<br>但し、主運に凶数があると、心身を労し不安動揺ありあて活動の割に功を得られず。神経障害による病や胃腸病等に悩まされるので注意が必要です。」"],
			# 1/2、7/8、7/8の場合
			["木・金・金", "△", "「健康には恵まれますが、自我心強く同化力にかけ、不平不満が多く不成功に終わる。数により家庭不和を生ずることもあり。」"],
			# 1/2、7/8、9/0の場合
			["木・金・水", "△", "「好調なるも数の凶はいずれ生ずる暗示あり。自我心強き者は、家庭不和も生ずる。」"],
			# 1/2、9/0、1/2の場合
			["木・水・木", "△", "「初めは順調なれど永くは保たれず、主運の凶数と相まって病弱・孤独に成りやすい。<br>但し、基礎運が吉数なる者は、環境は順調なる場合もある。」"],
			# 1/2、9/0、3/4の場合
			["木・水・火", "×", "「急禍急変を来たし、安定を失い気苦労多く、数により神経系の病、ノイローゼなどを生じ、家庭不和、家族に禍を生ずる暗示あり。」"],
			# 1/2、9/0、5/6の場合
			["木・水・土", "×", "「気苦労多く、いつしか失意し、次第に事が上手く回らなくなる。」"],
			# 1/2、9/0、7/8の場合
			["木・水・金", "△", "「互いに調和融合する吉兆を得て、数の凶も緩和され運気旺盛なり。<br>但し、晩年運が凶数の場合、主運の凶数と相まって病弱・孤独に成りやすい。」"],
			# 1/2、9/0、9/0の場合
			["木・水・水", "×", "「一時発展が目覚ましいが、数の凶は免れず、衰運孤独の暗示あり。」"],
			# 3/4、1/2、1/2の場合
			["火・木・木", "◎", "「万事順調、実力以上の発展し、目的成就する。」"],
			# 3/4、1/2、3/4の場合
			["火・木・火", "◎", "「万事順調、心身健和し成功運を強める。」"],
			# 3/4、1/2、5/6の場合
			["火・木・土", "◎", "「万事順調、平静、和順、安泰で希望伸長する。」"],
			# 3/4、1/2、7/8の場合
			["火・木・金", "×", "「心身不安定で目的不伸、希望伸びず。胃腸障害、腎臓、肝硬変など生じやすく、数により家庭不和あり。」"],
			# 3/4、1/2、9/0の場合
			["火・木・水", "×", "「初めは順調なるも永くは保たれず、次第に不調和逆位を来たし数の凶と相俟って不和、神経痛、冷え症などが生ずる。」"],
			# 3/4、3/4、1/2の場合
			["火・火・木", "○", "「感情的な面あるも、心身健和、安泰吉慶を享けて発展する。」"],
			# 3/4、3/4、3/4の場合
			["火・火・火", "△", "「特殊な発展となり才能や能力を発揮し仕事運、成功運は旺盛である。<br>但し、愛情面や異性問題に不安定で、時に多情、多恨型の暗示もあり。」"],
			# 3/4、3/4、5/6の場合
			["火・火・土", "○", "「感情的な面もあるが、万事安泰で発展する。」"],
			# 3/4、3/4、7/8の場合
			["火・火・金", "×", "「感情的、内心不安定、動揺を生じ、突発的な災厄の暗示あり。<br>神経障害、ノイローゼにより家庭不和をもたらすことあり。」"],
			# 3/4、3/4、9/0の場合
			["火・火・水", "×", "「病弱、不治の病、災厄多く、短命の暗示あり。」"],
			# 3/4、5/6、1/2の場合
			["火・土・木", "×", "「不伸気苦労多く、希望達成せず。神経障害、胃腸疾患などになりやすい。」"],
			# 3/4、5/6、3/4の場合
			["火・土・火", "◎", "「健康に恵まれ、目上の引き立てありて健全、成功発展する。」"],
			# 3/4、5/6、5/6の場合
			["火・土・土", "○", "「健康には恵ますが、温良和順すぎて進取の気性に乏しく、希望伸び悩み、平凡な人生となる。」"],
			# 3/4、5/6、7/8の場合
			["火・土・金", "◎", "「吉祥良く、内心強固だが外面温和な人柄で、人望厚く目下の支援を得て発展成功し、運気盛んなり。」"],
			# 3/4、5/6、9/0の場合
			["火・土・水", "×", "「何事も意のままにならず、意志が弱いのと相俟って次第に事が上手く回らなくなります。神経系の病を生ずる。」"],
			# 3/4、7/8、1/2の場合
			["火・金・木", "×", "「不伸、内心気苦労多く不安定。偏頭痛、ノイローゼ、または胃腸疾患などに陥り易い。」"],
			# 3/4、7/8、3/4の場合
			["火・金・火", "×", "「急禍急変の災厄あり。没落、変転する暗示あり。神経衰弱、ノイローゼになりやすい。」"],
			# 3/4、7/8、5/6の場合
			["火・金・土", "△", "「神経障害による偏頭痛、ノイローゼに陥り家庭不和など生ず。急変災厄多し。<br>但し、主運・基礎運ともに吉数なれば、境遇安泰、万事順調に発展する。」"],
			# 3/4、7/8、7/8の場合
			["火・金・金", "×", "「自我心強く、同化力に欠け、不和不調を来たし、家庭内でもトラブル生ずる。」"],
			# 3/4、7/8、9/0の場合
			["火・金・水", "×", "「一時は良好なるが、神経過敏で不眠症あるいは、胃腸疾患、リューマチの暗示あり。」"],
			# 3/4、9/0、1/2の場合
			["火・水・木", "×", "「一時は順調なれど、苦難、病難の逆境の暗示あり。稀に大成功者あり。」"],
			# 3/4、9/0、3/4の場合
			["火・水・火", "×", "「変転、急禍を生じ、ノイローゼになりやすく、短命の暗示あり。」"],
			# 3/4、9/0、5/6の場合
			["火・水・土", "×", "「一時成功はあっても、次第に事が上手く回らなくなり、精神安定ならず失意に嘆く。」"],
			# 3/4、9/0、7/8の場合
			["火・水・金", "×", "「健康、運気旺盛、財運に恵まれるも、家庭不和などあり。」"],
			# 3/4、9/0、9/0の場合
			["火・水・水", "×", "「一時発展目覚ましく成功あれど、流動し失意孤独の禍を生ずる。」"],
			# 5/6、1/2、1/2の場合
			["土・木・木", "△", "「不伸圧迫、希望伸び悩み、時に神経障害、胃腸疾患など生ずる。<br>但し、主運・基礎運が共に吉数の場合は、境遇安泰にして特に不安なし。」"],
			# 5/6、1/2、3/4の場合
			["土・木・火", "△", "「不伸圧迫、希望伸び悩み、時に神経障害、胃腸疾患など生ずる。<br>但し、主運・基礎運が共に吉数の場合は、健全発展し希望伸長する。」"],
			# 5/6、1/2、5/6の場合
			["土・木・土", "△", "「不伸圧迫、希望伸び悩み、時に神経障害、胃腸疾患など生ずる。<br>但し、主運・基礎運が共に吉数の場合は、平穏和順で安泰発展する。」"],
			# 5/6、1/2、7/8の場合
			["土・木・金", "×", "「基礎不安、目的不伸、希望伸び悩みの暗示あり。神経障害、胃腸病、腎臓、肝硬変などに注意。」"],
			# 5/6、1/2、9/0の場合
			["土・木・水", "×", "「一時は発展するも長くは保たれず、次第に不調和する。家庭不和、冷え症等に悩むことあり。」"],
			# 5/6、3/4、1/2の場合
			["土・火・木", "◎", "「健康に恵まれ、万事支障なく、境遇最も安泰にして目下の支援を得て、伸長す。」"],
			# 5/6、3/4、3/4の場合
			["土・火・火", "○", "「健康に恵まれ、成功運強く、目的迅速に発展する。<br>但し、急進的、感情的になると不和を生じて不幸を招く。」"],
			# 5/6、3/4、5/6の場合
			["土・火・土", "◎", "「健康に恵まれます。確固不動の安泰を得て、発展する。」"],
			# 5/6、3/4、7/8の場合
			["土・火・金", "×", "「成功運はあるが、内心不安定で気苦労多く、神経障害やノイローゼを生じ、家庭不和を招く暗示あり。」"],
			# 5/6、3/4、9/0の場合
			["土・火・水", "×", "「心が動揺し、安定性を欠き、神経系の病、ヒステリなど突発的な急禍を生じる。」"],
			# 5/6、5/6、1/2の場合
			["土・土・木", "×", "「温良和順すぎて進取の気質乏しい。不伸圧迫、気苦労多く、希望伸び悩み目下の力になれず。時に腹部の病を生ずる。」"],
			# 5/6、5/6、3/4の場合
			["土・土・火", "○", "「健康に恵まれます。温良和順、目下の支援を得て安泰発展する。」"],
			# 5/6、5/6、5/6の場合
			["土・土・土", "△", "「健康には恵まれますが、温良和順すぎて進取の気質乏しい。仕事運は良好なれど、異性問題や愛情面に不安を生ずることあり。」"],
			# 5/6、5/6、7/8の場合
			["土・土・金", "○", "「健康に恵まれ、表面温和で内心強固な人柄が功を得て、発展成功運強し。」"],
			# 5/6、5/6、9/0の場合
			["土・土・水", "×", "「基礎不安、失意で落ちぶれてゆく。冷え症等生じやすい。」"],
			# 5/6、7/8、1/2の場合
			["土・金・木", "×", "「内心気苦労が多く不安定。神経系の障害、腹部の病はいずれ生ずる。」"],
			# 5/6、7/8、3/4の場合
			["土・金・火", "×", "「急変急禍を来たす。神経障害によるノイローゼ、家庭不和を生ずる。」"],
			# 5/6、7/8、5/6の場合
			["土・金・土", "◎", "「胆力気力旺盛、境遇安泰で万事順調に発展する。」"],
			# 5/6、7/8、7/8の場合
			["土・金・金", "×", "「健康には恵まれますが、自我心強く反発的。人と対立したり同化力に乏しく、不平不満を生じ不幸を招く暗示あり。」"],
			# 5/6、7/8、9/0の場合
			["土・金・水", "×", "「一時的な発展はあるが、意外の変転を来たす暗示あり。」"],
			# 5/6、9/0、1/2の場合
			["土・水・木", "△", "「成功運あれど、努力すれども功を得難い。<br>但し、基礎運が吉数の場合は、環境安泰で、成功運強し。」"],
			# 5/6、9/0、3/4の場合
			["土・水・火", "×", "「安定を得られず変転と急禍急変を生ずる。<br>神経衰弱やノイローゼの暗示あり。」"],
			# 5/6、9/0、5/6の場合
			["土・水・土", "×", "「不安変化、目下の迫害などにより失意に嘆く。」"],
			# 5/6、9/0、7/8の場合
			["土・水・金", "△", "「成功運あれど、努力すれども功を得難い。<br>但し、基礎運が吉数の場合は、運気旺盛なり。<br>+gまた、主運に10画または20画を持つあなたは、家庭不和を招くことがある。-g」"],
			# 5/6、9/0、9/0の場合
			["土・水・水", "×", "「強大なる発展力と破壊力を併せ持つ。一時発展目覚ましいが、多くは病弱孤独となる。<br>稀に大成功者あり。」"],
			# 7/8、1/2、1/2の場合
			["金・木・木", "△", "「不伸圧迫、気苦労多く希望伸びず。時に神経系の病、胃腸疾患、腹部の病を生ず。<br>但し、主運・基礎運が吉数の場合には、この限りでなく穏健着実に伸長す。」"],
			# 7/8、1/2、3/4の場合
			["金・木・火", "△", "「不伸圧迫、気苦労多く希望伸びず。時に神経系の病、胃腸疾患、腹部の病を生ず。<br>但し、主運・基礎運が吉数の場合には、この限りでなく諸事順調で目的達成は容易。」"],
			# 7/8、1/2、5/6の場合
			["金・木・土", "△", "「不伸圧迫、気苦労多く希望伸びず。時に神経系の病、胃腸疾患、腹部の病を生ず。<br>但し、主運・基礎運が吉数の場合には、この限りでなく確固不動の安泰あり。」"],
			# 7/8、1/2、7/8の場合
			["金・木・金", "×", "「精神不安定や気苦労多く、特に神経衰弱、胃腸疾患、腎臓病、肝硬変などに注意」"],
			# 7/8、1/2、9/0の場合
			["金・木・水", "×", "「一時の発展はあるが、浮動しやすい。病弱、家庭不和、年令により冷え症やリューマチの暗示」"],
			# 7/8、3/4、1/2の場合
			["金・火・木", "△", "「急禍急変を来す暗示あり。心労多く、主運凶数の場合、人との対立、神経障害、偏頭痛に悩む。<br>但し、主運・基礎運が吉数の場合は、この限りではなく境遇安泰にして目下の支援により希望伸長する。」"],
			# 7/8、3/4、3/4の場合
			["金・火・火", "×", "「急進的、感情的になりやすく、神経過敏なるものは順和を欠き、不和の難あり」"],
			# 7/8、3/4、5/6の場合
			["金・火・土", "△", "「急禍急変を来す暗示あり。心労多く、主運凶数の場合、人との対立、神経障害、偏頭痛に悩む。<br>但し、主運・基礎運が吉数の場合は、この限りではなく着実、安泰に希望伸長、発展する。」"],
			# 7/8、3/4、7/8の場合
			["金・火・金", "×", "「内心不安定、急禍急変で、心臓マヒや脳溢血、ノイローゼに陥ることあり」"],
			# 7/8、3/4、9/0の場合
			["金・火・水", "×", "「急禍急変、不安動揺、突発的な病災を生ずることあり」"],
			# 7/8、5/6、1/2の場合
			["金・土・木", "×", "「目的不伸、希望伸び悩み不安定で目下の力になれず、胃腸病などあり」"],
			# 7/8、5/6、3/4の場合
			["金・土・火", "◎", "「万事順調、成功運強く、目下の支援を受けて発展す」"],
			# 7/8、5/6、5/6の場合
			["金・土・土", "○", "「万事順調なれど、温良和順すぎて進取の気性に欠け、中成功に止まる」"],
			# 7/8、5/6、7/8の場合
			["金・土・金", "○", "「万事順調、外面温和なれど内心不屈の精神で成功運強し」"],
			# 7/8、5/6、9/0の場合
			["金・土・水", "×", "「基礎不安定にて希望伸長ならず。神経系の病、冷え症に注意。数により家庭不和で孤立する者あり」"],
			# 7/8、7/8、1/2の場合
			["金・金・木", "×", "「内心気苦労が多く、神経質になりやすいため希望伸長せず。神経障害や腹部の病など生ずる」"],
			# 7/8、7/8、3/4の場合
			["金・金・火", "×", "「急禍急変、神経障害やノイローゼの暗示あり」"],
			# 7/8、7/8、5/6の場合
			["金・金・土", "○", "「平穏安泰で万事順調なり。<br>但し、自我心強く何事にも強引過ぎる時には失敗する」"],
			# 7/8、7/8、7/8の場合
			["金・金・金", "△", "「健康には恵まれますが、才能運や成功運が強く、芸能やスポーツなど特殊な職業に適する。<br>家庭運、異性問題に不安定を招くケースあり。多情、多恨なる者もあり。」"],
			# 7/8、7/8、9/0の場合
			["金・金・水", "×", "「心身過労にして、時に病弱、精神系の病の暗示あり。反面、大成功者もあり。」"],
			# 7/8、9/0、1/2の場合
			["金・水・木", "△", "「境遇順調なるも、数により病弱で家庭運に恵まれない者あり」"],
			# 7/8、9/0、3/4の場合
			["金・水・火", "×", "「急変急禍を生ずる。病弱短命の暗示あり」"],
			# 7/8、9/0、5/6の場合
			["金・水・土", "×", "「外見は良く見えるが内面は精神不安定で次第に事が運ばなくなる」"],
			# 7/8、9/0、7/8の場合
			["金・水・金", "◎", "「健康に恵まれ、運期旺盛にして発展する」"],
			# 7/8、9/0、9/0の場合
			["金・水・水", "×", "「一時発展が目覚ましいが、家庭運が悪く孤独になりやすい」"],
			# 9/0、1/2、1/2の場合
			["水・木・木", "◎", "「健康に恵まれ、平穏安泰で、実力以上の発展をする」"],
			# 9/0、1/2、3/4の場合
			["水・木・火", "◎", "「健康に恵まれ、平穏安泰、目下の支援を受けて目的達成容易なり」"],
			# 9/0、1/2、5/6の場合
			["水・木・土", "◎", "「健康に恵まれ、確固不動の安泰を得て、平穏和順なり」"],
			# 9/0、1/2、7/8の場合
			["水・木・金", "×", "「基礎不安定、気苦労多く、時に精神的な原因で腹部の疾患を生ずる」"],
			# 9/0、1/2、9/0の場合
			["水・木・水", "×", "「始めは順調に発展するも、次第に事が運ばなくなる」"],
			# 9/0、3/4、1/2の場合
			["水・火・木", "△", "「一時の成功はあっても健康的に恵まれず、突発的災厄、神経障害、ノイローゼの暗示がある。<br>但し、主運・基礎運が吉数の場合には、この限りでなく平穏安泰、目下の支援を得て発展する。」"],
			# 9/0、3/4、3/4の場合
			["水・火・火", "×", "「急進的、感情的になりやすく、内外共に不和を生ずる。<br>但し、数により問題なき事もある。」"],
			# 9/0、3/4、5/6の場合
			["水・火・土", "△", "「一時の成功はあっても健康的に恵まれず、突発的災厄、神経障害、ノイローゼの暗示がある。<br>但し、主運・基礎運が吉数の場合には、この限りでなく安泰無事発展する。」"],
			# 9/0、3/4、7/8の場合
			["水・火・金", "×", "「急禍急変を重ねる。数によりノイローゼや短命の暗示あり。」"],
			# 9/0、3/4、9/0の場合
			["水・火・水", "×", "「急禍急変を重ね、病弱、悲業、精神障害、ノイローゼ、短命などの暗示あり。」"],
			# 9/0、5/6、1/2の場合
			["水・土・木", "×", "「不伸圧迫で希望伸び悩み、神経系の病や胃腸病などになりやすい」"],
			# 9/0、5/6、3/4に場合
			["水・土・火", "△", "「経路困難が多く、一時の成功はあれど意志の弱い者は失意に嘆く。<br>但し、主運・基礎運が吉数の場合は、この限りでなく、健康に恵まれ、着実、安泰で目下の支援を受けて発展する。」"],
			# 9/0、5/6、5/6の場合
			["水・土・土", "○", "「健康に恵まれ、平穏安泰なるも、進取の気性に乏しく目的中成功に止まる」"],
			# 9/0、5/6、7/8の場合
			["水・土・金", "△", "「経路困難が多く、一時の成功はあれど意志の弱い者は失意に嘆く。<br>但し、主運・基礎運が吉数の場合は、この限りでなく、無事安泰、成功運や健康運も良好なり。」"],
			# 9/0、5/6、9/0の場合
			["水・土・水", "×", "「健康には恵まれますが、困難が多く、一時の成功はあっても、いずれは事が運ばなくなる」"],
			# 9/0、7/8、1/2の場合
			["水・金・木", "×", "「不伸、圧迫、不安定で気苦労多く、胃腸病や腹部の病の暗示あり」"],
			# 9/0、7/8、3/4の場合
			["水・金・火", "×", "「急禍急変、目下の迫害ありて希望伸び悩む。神経障害やノイローゼの暗示あり」"],
			# 9/0、7/8、5/6の場合
			["水・金・土", "◎", "「健康に恵まれ、境遇安泰で万事順調で成功運を強める」"],
			# 9/0、7/8、7/8の場合
			["水・金・金", "△", "「健康には恵まれますが、自我心強く、他人と同化しない為に不和を生じやすい。自我を戒めれば強い発展をする」"],
			# 9/0、7/8、9/0の場合
			["水・金・水", "△", "「心身苦労が多く、時に家庭不和を生ずる。大成功者と不遇失意の者に分れ判断が難しい」"],
			# 9/0、9/0、1/2の場合
			["水・水・木", "○", "「健康に恵まれ、環境順調なるも、数により不遇の暗示あり」"],
			# 9/0、9/0、3/4の場合
			["水・水・火", "×", "「急禍急変を来たし、病弱、精神障害、ノイローゼ、短命の暗示」"],
			# 9/0、9/0、5/6の場合
			["水・水・土", "×", "「外見吉祥なるも精神常に安らかず。何事も上手く行かない。」"],
			# 9/0、9/0、7/8の場合
			["水・水・金", "○", "「境遇安泰、気運旺盛で発展する。<br>但し、外画(外交運)に凶数あれば、家庭不和を生じ易く、運期が衰える」"],
			# 9/0、9/0、9/0の場合
			["水・水・水", "△", "「旺盛な才能を発揮して成功運は強い。<br>しかし一方に偏る為、家庭運と愛情運に不安定を来たす暗示」"]
		);
	}
}
?>