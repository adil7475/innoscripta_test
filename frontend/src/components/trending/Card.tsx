import React from "react";
import {Card, CardBody, CardTitle, CardText} from "reactstrap";
import {TrendingNewsCardType} from "../../types/news-cards";
import NewsImage from '../../assets/images/news.jpg'

export const TrendingCard = ({title, publishedAt, imageUrl}: TrendingNewsCardType) => {
    const newsImage = imageUrl ? imageUrl : NewsImage
    return (
        <Card className="mb-3 col-md-12">
            <div className="row g-0">
                <div className="col-md-3 col-4">
                    <img src={newsImage} alt="News" className="img-fluid rounded-start"/>
                </div>
                <div className="col-md-9 col-8">
                    <CardBody>
                        <CardText className="mb-1">
                            <span className="badge rounded-pill bg-secondary">{publishedAt}</span>
                        </CardText>
                        <CardTitle className="card-title">
                            {title}
                        </CardTitle>
                    </CardBody>
                </div>
            </div>
        </Card>
    );
}